<?php
/**
 * The base configuration options for bgtfw.
 *
 * @package Boldgrid_Theme_Framework
 * @subpackage Boldgrid_Theme_Framework\Configs
 *
 * @since    1.1
 *
 * @return   array   An array of base configs used in bgtfw.
 */

$theme_framework_dir = realpath( plugin_dir_path( __FILE__ ) . '../..' );

$theme_framework_uri = get_template_directory_uri()
	. '/inc/boldgrid-theme-framework';

if ( defined( 'BGTFW_PATH' ) ) {
	$theme_framework_uri = get_site_url() . BGTFW_PATH;
}

$theme_data = wp_get_theme();
$theme_parent = is_child_theme() ? $theme_data->template : $theme_data->stylesheet;

return array(

	// Temp configs rolling out to themes.
	'temp' => array(
		'attribution_links'    => false,
	),

	// Required From Theme - these are defaults.
	'theme_name' => $theme_data->stylesheet,
	'theme-parent-name' => $theme_parent,
	'version' => $theme_data->version,
	'framework-version' => implode( get_file_data( $theme_framework_dir . '/boldgrid-theme-framework.php', array( 'Version' ), 'plugin' ), '' ),
	'theme_id' => null,
	'boldgrid-parent-theme' => false,
	'bootstrap' => false,

	// End Required.
	'text_domain' => 'boldgrid-theme-framework',

	'font' => array(
		'translators' => 'on',
		'types' => array(
			'Roboto:300,400,500,700,900|Oswald'
		 ),
	),

	'framework' => array(
		'asset_dir'       => $theme_framework_dir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR,
		'includes_dir'    => $theme_framework_dir . '/includes/',
		'root_uri'        => $theme_framework_uri . '/',
		'webpack_server'  => 'http://localhost:4009/',
		'admin_asset_dir' => $theme_framework_uri . '/assets/',
		'js_dir'          => $theme_framework_uri . '/assets/js/',
		'css_dir'         => $theme_framework_uri . '/assets/css/',
		'inline_styles'   => false,
	),

	/**
	 * No Post Format Styles are required by default
	 * Theme authors can add post formats here. Eventually post formats will be required
	 * and can be added here
	 *
	 * @since 1.0.4
	 */
	'post_formats' => array(),

	/**
	 * Customizer Specific Configurations
	 *
	 * @since 1.0.0
	 */
	'customizer-options' => array(
		'site_logo'      => true,
		'header_panel'    => true,
		'header_controls' => array(
			'widgets'     => true,
			'custom_html' => true,
		),

		'footer_panel'    => true,
		'footer_controls' => array(
			'widgets'     => true,
			'custom_html' => true,
		),

		'advanced_panel' => true,
		'advanced_controls' => array(
			'css_editor' => true,
			'js_editor'  => true,
		),
		'effects_panel' => false,
	),
);
