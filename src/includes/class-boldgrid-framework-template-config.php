<?php
/**
 * Class: Boldgrid_Framework_Template_Config
 *
 * This is used to set template based configuration options.
 *
 * This pulls configuration, directories and version information from the framework configs.
 *
 * @since      1.1.1
 * @package    BoldGrid_Framework
 * @author     BoldGrid <support@boldgrid.com>
 * @link       https://boldgrid.com
 */

/**
 * Class: BoldGrid_Framework_Template_Config
 *
 * This is used to set template based configuration options.
 *
 * This pulls configuration, directories and version information from the framework configs.
 *
 * @since      1.1.1
 */
class BoldGrid_Framework_Template_Config {

	/**
	 * The BoldGrid Theme Framework configurations.
	 *
	 * @since     1.1.1
	 * @access    protected
	 * @var       array     $configs       The BoldGrid Theme Framework configurations.
	 */
	protected $configs;

	/**
	 * Locations thats have been registered for use by the theme.
	 *
	 * @since     1.2
	 * @access    protected
	 * @var       array     $enabled_locations       List of registered locations.
	 */
	protected $enabled_locations = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param     array $configs       The BoldGrid Theme Framework configurations.
	 * @since     1.1.1
	 */
	public function __construct( $configs ) {
		$this->configs = $configs;
	}

	/**
	 * Determines which config to assign based on template.
	 *
	 * This function searches the assigned header and footer configs,
	 * and returns an array of template configs to assign.
	 *
	 * @return $configs array Array of configs to assign to menu location.
	 *
	 * @since 1.1.1
	 */
	public function template_config() {
		$header = self::get_active_template( 'header' ) . '_config';
		$footer = self::get_active_template( 'footer' ) . '_config';
		$configs = array();

		if ( false === is_callable( array( $this, $header ) ) ) {
			$header = 'header_config';
		}

		if ( false === is_callable( array( $this, $footer ) ) ) {
			$footer = 'footer_config';
		}

		$configs = array_merge( self::$header(), self::$footer() );

		return $configs;
	}

	/**
	 * Get active footer and header templates.
	 *
	 * @param string $type  Type of template to check (header/footer).
	 * @return string $filter[$type] The active template in use by theme.
	 *
	 * @since 1.1.1
	 */
	private function get_active_template( $type ) {
		$template = $this->configs['template'];
		$filtered = array();

		foreach ( $template as $key => $value ) {
			$sep = ( '' === $value ) ? null : '_';
			if ( 0 === strpos( $key, 'header' ) || 0 === strpos( $key, 'footer' ) ) {
				$filtered[ $key ] = $key . $sep . $value;
			}
		}

		return $filtered[ $type ];
	}

	/**
	 * Default Header Template Configuration.
	 *
	 * This will set the default configuration options for
	 * header template 1 if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function header_config() {
		return array(
			'primary' => 'Primary Menu',
			'secondary' => 'Above Header',
			'tertiary'  => 'Below Primary Menu',
			'social'    => 'Above Primary Menu',
		);
	}

	/**
	 * Header Template 1 Configuration.
	 *
	 * This will set the default configuration options for
	 * header template 1 if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function header_1_config() {
		// Menu Locations.
		return array(
			'primary' => 'Primary Menu',
			'secondary' => 'Above Header',
			'tertiary'  => 'Below Primary Menu',
			'social'    => 'Above Primary Menu',
		);
	}

	/**
	 * Header Template 2 Configuration
	 *
	 * This will set the default configuration options for
	 * header template 2 if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function header_2_config() {
		// Menu Locations.
		return array(
			'primary' => 'Primary Menu',
			'secondary' => 'Above Header',
			'tertiary'  => 'Above Primary 1',
			'social'    => 'Above Primary 2',
		);
	}

	/**
	 * Header Template 3 Configuration
	 *
	 * This will set the default configuration options for
	 * header template 3 if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function header_3_config() {
		// Menu Locations.
		return array(
			'primary' => 'Primary Menu',
			'secondary' => 'Above Header',
			'tertiary'  => 'Above Primary',
			'social'    => 'Above Primary',
		);
	}

	/**
	 * Header Template 4 Configuration
	 *
	 * This will set the default configuration options for
	 * header template 4 if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function header_4_config() {
		// Menu Locations.
		return array(
			'primary' => 'Primary Menu',
			'secondary' => 'Above Header',
			'tertiary'  => 'Above Primary',
			'social'    => 'Above Primary',
		);
	}

	/**
	 * Header Template 5 Configuration
	 *
	 * This will set the default configuration options for
	 * header template 5 if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function header_5_config() {
		// Menu Locations.
		return array(
			'primary' => 'Primary Menu',
			'secondary' => 'Above Header',
			'tertiary'  => 'Above Primary',
			'social'    => 'Above Primary',
		);
	}

	/**
	 * Default Footer Template Configuration
	 *
	 * This will set the default configuration options for the
	 * default footer template if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function footer_config() {
		// Menu Locations.
		return array(
			'footer_center'    => 'Footer Center',
		);
	}

	/**
	 * Footer Template 1 Configuration
	 *
	 * This will set the default configuration options for
	 * footer template 1 if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function footer_1_config() {
		// Menu Locations.
		return array(
			'footer_center' => 'Footer Center',
		);
	}

	/**
	 * Footer Template 2 Configuration
	 *
	 * This will set the default configuration options for
	 * footer template 2 if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function footer_2_config() {
		// Menu Locations.
		return array(
			'footer_center' => 'Footer Center',
		);
	}

	/**
	 * Footer Template 3 Configuration
	 *
	 * This will set the default configuration options for
	 * footer template 3 if it's in use.
	 *
	 * @return array array An array containing menu locations.
	 *
	 * @since 1.1.1
	 */
	private function footer_3_config() {
		// Menu Locations.
		return array(
			'footer_social'    => 'Footer Right',
			'footer_center' => 'Footer Left',
		);
	}

	/**
	 * Add style configs for pagination.
	 *
	 * If the style is defined as buttons for pagination, override the classes for paging and posts
	 * nav classes to add button-primary or whatever the configs for that post are.
	 *
	 * @since 1.5
	 *
	 * @return array Configuration.
	 */
	public function pagination_style( $configs ) {
		$post_navigation = $configs['template']['post_navigation'];

		if ( 'buttons' === $post_navigation['style'] ) {
			$pageing_nav_classes = $post_navigation['style_configs']['buttons']['paging_nav_classes'];
			$post_navigation['paging_nav_classes']['next'] .= ' ' . $pageing_nav_classes;
			$post_navigation['paging_nav_classes']['previous'] .= ' ' . $pageing_nav_classes;

			$post_nav_classes = $post_navigation['style_configs']['buttons']['post_nav_classes'];
			$post_navigation['post_nav_classes']['next'] .= ' ' . $post_nav_classes;
			$post_navigation['post_nav_classes']['previous'] .= ' ' . $post_nav_classes;
		}

		$configs['template']['post_navigation'] = $post_navigation;

		return $configs;
	}

	/**
	 * Hide all of the location rows that are not in use.
	 *
	 * @since 1.2
	 */
	public function print_styles() {
		$css = array();
		foreach ( $this->configs['template']['generic-location-rows'] as $area_name => $location_area ) {
			foreach ( $location_area as $location_row ) {

				$area_locations = ! empty( $this->enabled_locations[ $area_name ] ) ?
					$this->enabled_locations[ $area_name ] : array();
				$intersect = array_intersect( $location_row, $area_locations );

				// Create CSS array.
				if ( empty( $intersect ) ) {
					$classname = ".row.{$area_name}-{$location_row[0]}";
					$css[ $classname ] = array(
						'display' => 'none',
					);
				}
			}
		}

		print BoldGrid_Framework_Styles::convert_array_to_css( $css, 'boldgrid-locations' );
	}

	/**
	 * Setup the ability to use action configs.
	 *
	 * @since 1.1.1
	 */
	public function do_location_action( $template_type, $location_id  ) {
		if ( ! empty( $this->configs['template']['locations'][ $template_type ][ $location_id ] ) ) {
			$location_items = $this->configs['template']['locations'][ $template_type ][ $location_id ];

			// Wrap in array if non existant.
			if ( false === is_array( $location_items ) ) {
				$location_items = array( $location_items );
			}

			// Add to the list of enabled locations.
			$this->enabled_locations[ $template_type ][] = $location_id;

			foreach ( $location_items as $action ) {

				// Split [action]action-name to [action] and action-name
				preg_match( '/^\[.*\]/', $action, $matches );
				$type = ! empty( $matches[0] ) ? $matches[0] : null;
				$name = str_ireplace( $type, '', $action );

				switch ( $type ) {
					case '[menu]':
						do_action( 'boldgrid_menu_' . $name );
						break;
					case '[widget]':
						bgtfw_widget( $name, true );
						break;
					default:
					case '[action]':
						do_action( $name );
						break;
				}
			}
		}
	}

	/**
	 * Adds the sidebar templates for pages and posts to the
	 * page/post attributes dropdowns in the WordPress editor.
	 *
	 * @since 2.0
	 *
	 * @param array $templates Array of available templates to choose from.
	 *
	 * @return array $templates The modified $templates array.
	 */
	public function templates( $templates ) {
		$templates['no-sidebar'] = 'No Sidebar';
		$templates['right-sidebar'] = 'Right Sidebar';
		$templates['left-sidebar'] = 'Left Sidebar';

		return $templates;
	}
}
