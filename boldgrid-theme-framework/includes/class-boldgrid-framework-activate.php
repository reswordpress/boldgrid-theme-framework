<?php
/**
 * Class: Boldgrid_Framework_Activate
 *
 * This class contians code that will run on activation
 * of a theme that utilizes the BoldGrid Theme Framework.
 *
 * @since 1.0.0
 * @package Boldgrid_Framework
 * @subpackage Boldgrid_Framework_Activate
 * @author BoldGrid <support@boldgrid.com>
 * @link https://boldgrid.com
 */

/**
 * Class: Boldgrid_Framework_Activate
 *
 * This class contians code that will run on activation
 * of a theme that utilizes the BoldGrid Theme Framework.
 *
 * @since 1.0.0
 */
class Boldgrid_Framework_Activate {

	/**
	 * The BoldGrid Theme Framework configurations.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string $configs The BoldGrid Theme Framework configurations.
	 */
	protected $configs;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $configs The BoldGrid Theme Framework configurations.
	 * @since 1.0.0
	 */
	public function __construct( $configs ) {
		$this->configs = $configs;
		$this->widgets = new Boldgrid_Framework_Widgets( $this->configs );
		$this->menus   = new Boldgrid_Framework_Menu( $this->configs );
		$this->scss    = new Boldgrid_Framework_SCSS( $this->configs );
		$this->color   = new Boldgrid_Framework_Customizer_Colors( $this->configs );
	}

	/**
	 * Reset The Boldgrid Theme Framework
	 * Removing any menu locations and widget locations
	 *
	 * @since 1.0.0
	 *
	 * @param bool $active Are we resetting an active installation.
	 */
	public function reset( $active = true ) {

		$this->widgets->remove_saved_widgets();
		$this->menus->reset_nav_locations();
		$this->menus->remove_saved_menus( $active );

		// Delete Option indicating that the framework needs to be setup.
		delete_option( 'boldgrid_framework_init' );

		// Do action for 3rd party.
		do_action( 'boldgrid_theme_reset' );
	}

	/**
	 * Activate Boldgrid theme framework
	 *
	 * @since 1.0.0
	 */
	public function do_activate() {
		if ( $this->menus->is_user_child() ) {
			return;
		}

		// Before running the activation, run deactivate just to be sure.
		$this->reset();

		$this->widgets->empty_widget_areas();
		$this->widgets->set_widget_areas();

		// Create Default Menus.
		$this->menus->create_default_menus();

		// Then update the menu_check option to make sure this code only runs once.
		update_option( 'boldgrid_framework_init', true );

		// Set Color Palettes.
		$this->set_palette();

		// Do action for 3rd party.
		do_action( 'boldgrid_theme_activate' );
	}

	/**
	 * Remove any theme mods that were transferred to this theme
	 *
	 * @since 1.0.0
	 */
	public function undo_theme_mod_transfer() {
		$accept = true;
		$data = wp_unslash( $_POST['data']['accept'] );

		if ( ! empty( $data ) ) {
			$accept = $data;
		}
		if ( false === $accept ) {
			$theme_mods = get_option( 'theme_mods_' . get_stylesheet(), array() );
			if ( ! empty( $theme_mods['transferred_theme_mods'] ) && is_array( $theme_mods['transferred_theme_mods'] ) ) {
				foreach ( $theme_mods['transferred_theme_mods'] as $theme_mod ) {
					unset( $theme_mods[ $theme_mod ] );
				}
				$theme_mods['transferred_theme_mods'] = array();
			}

			update_option( 'theme_mods_' . get_stylesheet(), $theme_mods );

			// Compile All SCSS again!
			$this->scss->force_update_css();
		} else {
			// If accepted, reset the array of theme mods.
			set_theme_mod( 'transferred_theme_mods', array() );
		}

		wp_die();
	}

	/**
	 * Check & set the default palette theme mod and compile the css
	 * for a user that has not selected a new palette and uses
	 * the theme's defined default palette.
	 *
	 * @since 1.1.7
	 */
	public function set_palette() {
		// Check if staging and active.
		// Theme mod to check if a palette has been set yet.
		$option = get_option( 'theme_mods_' . get_stylesheet() );
		// Check that options exist.
		if ( false === $option ) {
			return;
		}
		// If there's not a palette set by user, then set it.
		if ( ! array_key_exists( 'boldgrid_color_palette', $option ) ) {
			// Check Configs For Default Palettes.
			$palette = $this->configs['customizer-options']['colors']['defaults'];
			// Initizalize $theme_mod array.
			$theme_mod = array();
			// Get assigned default palette for category/theme.
			$default_palette = $this->color->get_simplified_external_palettes( $palette );
			// Reset to access without specifying palette format as it can change.
			$active_palette = reset( $default_palette );
			// Find acitve palette format.
			$format = $active_palette['format'];
			// Set the theme mod array values.
			$theme_mod['state'] = array(
				'active-palette' => $format,
				'active-palette-id' => $this->color->create_palette_id( $active_palette ),
				'palettes' => $default_palette,
				'saved_palettes' => array(),
			);
			// This is not needed for theme mod.
			unset( $theme_mod['state']['palettes'][ $format ]['default'] );
			// Encode to pass to JS.
			$encoded_theme_mod = wp_json_encode( $theme_mod );

			// Set the theme mods.
			$option['boldgrid_color_palette'] = $encoded_theme_mod;
			$option['boldgrid_palette_class'] = $format;
			// Update the theme mods.
			update_option( 'theme_mods_' . get_stylesheet(), $option );
		}
	}
	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register five plugins:
	 * - one included with the TGMPA library
	 * - two from an external source, one from an arbitrary source, one from a GitHub repository
	 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
	 *
	 * The variables passed to the `tgmpa()` function should be:
	 * - an array of plugin arrays;
	 * - optionally a configuration array.
	 * If you are not changing anything in the configuration array, you can remove the array and remove the
	 * variable from the function call: `tgmpa( $plugins );`.
	 * In that case, the TGMPA default settings will be used.
	 *
	 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
	 */
	public function register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			array(
				'name'      => 'BoldGrid Inspirations',
				'slug'      => 'boldgrid-inspirations',
				'source'    => 'https://github.com/BoldGrid/boldgrid-inspirations/archive/master.zip',
				'required'  => true, // If false, the plugin is only 'recommended' instead of required.
			),
			array(
				'name'      => 'BoldGrid Editor',
				'slug'      => 'boldgrid-editor',
				'source'    => 'https://github.com/BoldGrid/boldgrid-editor/archive/master.zip',
				'required'  => true, // If false, the plugin is only 'recommended' instead of required.
			),
			array(
				'name'      => 'BoldGrid Gallery',
				'slug'      => 'boldgrid-gallery',
				'source'    => 'https://github.com/BoldGrid/boldgrid-gallery/archive/master.zip',
				'required'  => false, // If false, the plugin is only 'recommended' instead of required.
			),
			array(
				'name'      => 'BoldGrid SEO',
				'slug'      => 'boldgrid-seo',
				'source'    => 'https://github.com/BoldGrid/boldgrid-seo/archive/master.zip',
				'required'  => false, // If false, the plugin is only 'recommended' instead of required.
			),
			array(
				'name'      => 'BoldGrid Staging',
				'slug'      => 'boldgrid-staging',
				'source'    => 'https://github.com/BoldGrid/boldgrid-staging/archive/master.zip',
				'required'  => false, // If false, the plugin is only 'recommended' instead of required.
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$tgm_configs = array(
			'id'           => 'bgtfw',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'bgtfw-install-plugins', // Menu slug.
			'parent_slug'  => 'plugins.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $tgm_configs );
	}
}
