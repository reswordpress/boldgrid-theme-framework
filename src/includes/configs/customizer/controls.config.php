<?php
/**
 * Customizer Controls Configs
 *
 * @package Boldgrid_Theme_Framework
 * @subpackage Boldgrid_Theme_Framework\Configs
 *
 * @since 2.0.0
 *
 * @return array Controls to create in the WordPress Customizer.
 */

global $boldgrid_theme_framework;
$configs = $boldgrid_theme_framework->get_configs();

// Check that get_page_templates() method is available in the customizer.
if ( ! function_exists( 'get_page_templates' ) ) {
	require_once ABSPATH . 'wp-admin/includes/theme.php';
}

$palette = new Boldgrid_Framework_Compile_Colors( $this->configs );
$active_palette = $palette->get_active_palette();
$formatted_palette = $palette->color_format( $active_palette );
$sanitize = new Boldgrid_Framework_Customizer_Color_Sanitize();

return array(
	array(
		'type'        => 'code',
		'settings'    => 'custom_theme_js',
		'label'       => __( 'JS code' ),
		'help'        => __( 'This adds live JavaScript to your website.', 'bgtfw' ),
		'description' => __( 'Add custom javascript for this theme.', 'bgtfw' ),
		'section'     => 'custom_css',
		'default'     => "// jQuery('body');",
		'priority'    => 10,
		'choices'     => array(
			'language' => 'javascript',
			'theme'    => 'base16-dark',
			'height'   => 100,
		),
	),
	array(
		'type'        => 'bgtfw-palette-selector',
		'transport' => 'postMessage',
		'settings'    => 'boldgrid_background_color',
		'label' => esc_attr__( 'Color', 'bgtfw' ),
		'description' => esc_attr__( 'Choose a color from your palette to use.', 'bgtfw' ),
		'tooltip' => 'testing what a tool tip looks like',
		'section'     => 'background_image',
		'priority' => 1,
		'default'     => '',
		'choices'     => array(
			'colors' => $formatted_palette,
			'size' => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'type' => 'slider',
		'settings' => 'boldgrid_background_vertical_position',
		'label' => __( 'Vertical Background Position', 'bgtfw' ),
		'section' => 'background_image',
		'transport' => 'postMessage',
		'default' => '0',
		'priority' => 16,
		'choices' => array(
			'min' => - 100,
			'max' => 100,
			'step' => 1,
		),
	),
	array(
		'type' => 'slider',
		'settings' => 'boldgrid_background_horizontal_position',
		'label' => __( 'Horizontal Background Position', 'bgtfw' ),
		'section' => 'background_image',
		'transport' => 'postMessage',
		'default' => '0',
		'priority' => 17,
		'choices' => array(
			'min' => -100,
			'max' => 100,
			'step' => 1,
		),
	),
	array(
		'type'        => 'radio',
		'settings'    => 'bgtfw_layout_page',
		'label'       => __( 'Default Sidebar Display', 'bgtfw' ),
		'section'     => 'bgtfw_layout_page',
		'default'     => 'no-sidebar',
		'priority'    => 10,
		'choices'     => array(),
	),
	array(
		'type' => 'radio',
		'settings' => 'bgtfw_pages_display_title',
		'label' => esc_html__( 'Page Title', 'bgtfw' ),
		'section' => 'bgtfw_layout_page',
		'priority' => 40,
		'default' => '1',
		'choices' => array(
			'1' => esc_attr__( 'Show', 'bgtfw' ),
			'0' => esc_attr__( 'Hide', 'bgtfw' ),
		),
	),
	array(
		'type' => 'radio',
		'settings' => 'bgtfw_posts_display_title',
		'label' => esc_html__( 'Post Title', 'bgtfw' ),
		'section' => 'bgtfw_pages_blog_posts_layout',
		'priority' => 40,
		'default' => '1',
		'choices' => array(
			'1' => esc_attr__( 'Show', 'bgtfw' ),
			'0' => esc_attr__( 'Hide', 'bgtfw' ),
		),
	),
	array(
		'type'        => 'bgtfw-palette-selector',
		'transport'   => 'postMessage',
		'settings'    => 'bgtfw_headings_color',
		'label'       => esc_attr__( 'Color', 'bgtfw' ),
		'section'     => 'headings_typography',
		'priority'    => 10,
		'default'     => '',
		'choices'     => array(
			'colors'  => $formatted_palette,
			'size'    => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'type'     => 'typography',
		'settings'  => 'bgtfw_headings_typography',
		'transport'   => 'auto',
		'settings'    => 'bgtfw_headings_typography',
		'label'       => esc_attr__( 'Headings Typography', 'bgtfw' ),
		'section'     => 'headings_typography',
		'default'     => array(
			'font-family'    => 'Roboto',
			'variant'        => 'regular',
			'font-size'      => '14px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'text-transform' => 'none',
		),
		'priority'    => 20,
		'output'      => array(
			array(
				'element'  => implode( ', ', array_keys( $this->configs['customizer-options']['typography']['selectors'] ) ),
			),
		),
	),
	array(
		'type'        => 'bgtfw-palette-selector',
		'transport'   => 'postMessage',
		'settings'    => 'bgtfw_tagline_color',
		'label'       => esc_attr__( 'Color', 'bgtfw' ),
		'section'     => 'bgtfw_tagline',
		'priority'    => 10,
		'default'     => '',
		'choices'     => array(
			'colors'  => $formatted_palette,
			'size'    => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'type'        => 'typography',
		'transport'   => 'auto',
		'settings'    => 'bgtfw_tagline_typography',
		'label'       => esc_attr__( 'Typography', 'bgtfw' ),
		'section'     => 'bgtfw_tagline',
		'default'     => array(
			'font-family'    => 'Roboto',
			'variant'        => 'regular',
			'font-size'      => '42px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'text-transform' => 'none',
			'text-align'     => 'left',
		),
		'priority'    => 20,
		'output'      => array(
			array(
				'element' => '.site-branding .site-description',
			),
		),
	),
	array(
		'type'        => 'switch',
		'transport'   => 'postMessage',
		'settings'    => 'bgtfw_fixed_header',
		'label'       => esc_attr__( 'Sticky Header', 'bgtfw' ),
		'section'     => 'bgtfw_header_layout',
		'default'     => false,
		'priority'    => 10,
	),
	array(
		'type'        => 'slider',
		'settings'    => 'bgtfw_header_width',
		'transport'   => 'auto',
		'label'       => esc_attr__( 'Header Width', 'bgtfw' ),
		'section'     => 'bgtfw_header_layout',
		'default'     => 400,
		'choices'     => array(
			'min'  => '0',
			'max'  => '600',
			'step' => '1',
		),
		'active_callback' => array(
			array(
				'setting'  => 'bgtfw_header_layout_position',
				'operator' => '!=',
				'value'    => 'header-top',
			),
		),
		'output' => array(
			array(
				'media_query' => '@media only screen and (min-width : 768px)',
				'element'  => '.flexbox .header-left .site-header, .flexbox .header-right .site-header',
				'property' => 'flex',
				'value_pattern' => '0 0 $px',
			),
			array(
				'media_query' => '@media only screen and (max-width : 968px)',
				'element'  => '.flexbox .header-left .site-content, .flexbox .header-right .site-content',
				'property' => 'flex',
				'value_pattern' => '1 0 calc(100% - $px)',
			),
			array(
				'media_query' => '@media only screen and (min-width : 768px)',
				'element'  => ' .flexbox .header-left.header-fixed .site-footer, .flexbox .header-right.header-fixed .site-footer',
				'property' => 'width',
				'value_pattern' => 'calc(100% - $px)',
			),
			array(
				'media_query' => '@media only screen and (min-width : 768px)',
				'element'  => '.flexbox .header-left .site-content, .flexbox .header-left.header-fixed .site-footer, .flexbox .header-right .site-content, .flexbox .header-right.header-fixed .site-footer',
				'property' => 'width',
				'value_pattern' => 'calc(100% - $px)',
			),
			array(
				'media_query' => '@media only screen and (min-width : 768px)',
				'element'  => '.flexbox .header-right.header-fixed .site-header, .flexbox .header-left.header-fixed .site-header, .header-right .wp-custom-header, .header-left .wp-custom-header, .header-right .site-header, .header-left .site-header, .header-left #masthead, .header-right #masthead',
				'property' => 'width',
				'value_pattern' => '$px',
			),
			array(
				'media_query' => '@media only screen and (min-width : 768px)',
				'element'  => '.header-left #navi-wrap, .header-right #navi-wrap',
				'property' => 'max-width',
				'value_pattern' => '$px',
			),
			array(
				'media_query' => '@media only screen and (min-width : 768px)',
				'element'  => '.flexbox .header-right.header-fixed .site-footer, .flexbox .header-right.header-fixed .site-content',
				'property' => 'margin-right',
				'value_pattern' => '$px',
			),
			array(
				'media_query' => '@media only screen and (min-width : 768px)',
				'element'  => '.flexbox .header-left.header-fixed .site-footer, .flexbox .header-left.header-fixed .site-content',
				'property' => 'margin-left',
				'value_pattern' => '$px',
			),
		),
	),

	array(
		'type'        => 'bgtfw-palette-selector',
		'transport' => 'postMessage',
		'settings'    => 'bgtfw_header_color',
		'label' => esc_attr__( 'Background Color', 'bgtfw' ),
		'section'     => 'bgtfw_header_colors',
		'priority' => 1,
		'default'     => '',
		'choices'     => array(
			'colors' => $formatted_palette,
			'size' => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'type'        => 'bgtfw-palette-selector',
		'transport' => 'postMessage',
		'settings'    => 'bgtfw_header_headings_color',
		'label' => esc_attr__( 'Headings Color', 'bgtfw' ),
		'section'     => 'bgtfw_header_colors',
		'priority' => 1,
		'default'     => '',
		'choices'     => array(
			'colors' => $formatted_palette,
			'size' => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'type'        => 'bgtfw-palette-selector',
		'transport' => 'postMessage',
		'settings'    => 'bgtfw_header_links',
		'label' => esc_attr__( 'Link Color', 'bgtfw' ),
		'section'     => 'bgtfw_header_colors',
		'priority' => 1,
		'default'     => '',
		'choices'     => array(
			'colors' => $formatted_palette,
			'size' => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'type'        => 'bgtfw-palette-selector',
		'transport' => 'postMessage',
		'settings'    => 'bgtfw_site_title_color',
		'label' => esc_attr__( 'Color', 'bgtfw' ),
		'section'     => 'bgtfw_site_title',
		'priority' => 10,
		'default'     => '',
		'choices'     => array(
			'colors' => $formatted_palette,
			'size' => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'type'        => 'typography',
		'transport'   => 'auto',
		'settings'    => 'bgtfw_site_title_typography',
		'label'       => esc_attr__( 'Typography', 'bgtfw' ),
		'section'     => 'bgtfw_site_title',
		'default'     => array(
			'font-family'    => 'Roboto',
			'variant'        => 'regular',
			'font-size'      => '42px',
			'line-height'    => '1.5',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'text-transform' => 'none',
			'text-align'     => 'left',
		),
		'priority'    => 20,
		'output'      => array(
			array(
				'element' => '.' . get_theme_mod( 'boldgrid_palette_class', 'palette-primary' ) . ' .site-header .site-title > a,.' . get_theme_mod( 'boldgrid_palette_class', 'palette-primary' ) . ' .site-header .site-title > a:hover',
			),
		),
	),
	array(
		'type'        => 'typography',
		'transport'   => 'auto',
		'settings'    => 'bgtfw_body_typography',
		'label'       => esc_attr__( 'Typography', 'bgtfw' ),
		'section'     => 'body_typography',
		'default'     => array(
			'font-family'    => 'Roboto',
			'variant'        => '100',
			'font-size'      => '18px',
			'line-height'    => '1.4',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'text-transform' => 'none',

		),
		'priority'    => 10,
		'output'      => array(
			array(
				'element' => 'body, p, .site-content, .site-footer',
			),
		),
	),
	array(
		'type'        => 'custom',
		'settings'     => 'boldgrid_attribution_heading',
		'label'       => __( 'Attribution Control', 'bgtfw' ),
		'section'     => 'boldgrid_footer_panel',
		'default'     => '',
		'priority'    => 20,
	),
	array(
		'type'        => 'checkbox',
		'settings'     => 'hide_boldgrid_attribution',
		'transport'   => 'refresh',
		'label'       => __( 'Hide BoldGrid Attribution', 'bgtfw' ),
		'section'     => 'boldgrid_footer_panel',
		'default'     => false,
		'priority'    => 30,
	),
	array(
		'type'        => 'checkbox',
		'settings'     => 'hide_wordpress_attribution',
		'transport'   => 'refresh',
		'label'       => __( 'Hide WordPress Attribution', 'bgtfw' ),
		'section'     => 'boldgrid_footer_panel',
		'default'     => false,
		'priority'    => 40,
	),
	array(
		'type'        => 'repeater',
		'label'       => esc_attr__( 'Contact Details', 'bgtfw' ),
		'section'     => 'boldgrid_footer_panel',
		'priority'    => 10,
		'row_label' => array(
			'field' => 'contact_block',
			'type' => 'field',
			'value' => esc_attr__( 'Contact Block', 'bgtfw' ),
		),
		'settings'    => 'boldgrid_contact_details_setting',
		'default'     => array(
			array(
				'contact_block' => '© ' . date( 'Y' ) . ' ' . get_bloginfo( 'name' ),
			),
			array(
				'contact_block' => esc_attr( '202 Grid Blvd. Agloe, NY 12776' ),
			),
			array(
				'contact_block' => esc_attr( '777-765-4321' ),
			),
			array(
				'contact_block' => esc_attr( 'info@example.com' ),
			),
		),
		'fields' => array(
			'contact_block' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Text', 'bgtfw' ),
				'description' => esc_attr__( 'Enter the text to display in your contact details', 'bgtfw' ),
				'default'     => '',
			),
		),
	),
	array(
		'type' => 'switch',
		'settings' => 'boldgrid_enable_footer',
		'label' => __( 'Enable Footer', 'bgtfw' ),
		'section' => 'boldgrid_footer_panel',
		'default' => true,
		'priority' => 5,
	),
	array(
		'type'        => 'custom',
		'settings'     => 'boldgrid_footer_widget_help',
		'section'     => 'bgtfw_footer_widgets',
		'default'     => '<a class="button button-primary open-widgets-section">' . __( 'Continue to Widgets Section', 'bgtfw' ) . '</a>',
		'priority'    => 10,
		'description' => __( 'You can add widgets to your footer from the widgets section.', 'bgtfw' ),
		'required' => array(
			array(
				'settings' => 'boldgrid_enable_footer',
				'operator' => '==',
				'value' => true,
			),
		),
	),
	array(
		'label'       => __( 'Footer Widget Areas', 'bgtfw' ),
		'description' => __( 'Select the number of footer widget columns you wish to display.', 'bgtfw' ),
		'type'        => 'number',
		'settings'    => 'boldgrid_footer_widgets',
		'priority'    => 15,
		'default'     => 0,
		'transport'   => 'auto',
		'choices'     => array(
			'min'  => 0,
			'max'  => 6,
			'step' => 1,
		),
		'section'     => 'bgtfw_footer_widgets',
		'partial_refresh' => array(
			'boldgrid_footer_widgets' => array(
				'selector'        => '#footer-widget-area',
				'render_callback' => array( 'Boldgrid_Framework_Customizer_Widget_Areas', 'footer_html' ),
				'container_inclusive' => true,
			),
		),
	),
	array(
		'type'        => 'custom',
		'settings'     => 'bgtfw_header_widget_help',
		'section'     => 'bgtfw_header_widgets',
		'default'     => '<a class="button button-primary open-widgets-section">' . __( 'Continue to Widgets Section', 'bgtfw' ) . '</a>',
		'priority'    => 10,
		'description' => __( 'You can add widgets to your header from the widgets section.', 'bgtfw' ),
	),
	array(
		'label'       => __( 'Header Widget Areas', 'bgtfw' ),
		'description' => __( 'Select the number of header widget columns you wish to display.', 'bgtfw' ),
		'type'        => 'number',
		'settings'    => 'boldgrid_header_widgets',
		'priority'    => 80,
		'default'     => 0,
		'transport'   => 'auto',
		'choices'     => array(
			'min'  => 0,
			'max'  => 6,
			'step' => 1,
		),
		'section'     => 'bgtfw_header_widgets',
		'partial_refresh' => array(
			'boldgrid_header_widgets' => array(
				'selector'        => '#header-widget-area',
				'render_callback' => array( 'Boldgrid_Framework_Customizer_Widget_Areas', 'header_html' ),
			),
		),
	),
	array(
		'type'        => 'bgtfw-palette-selector',
		'transport' => 'postMessage',
		'settings'    => 'bgtfw_footer_color',
		'label' => esc_attr__( 'Background Color', 'bgtfw' ),
		'description' => esc_attr__( 'Choose a color from your palette to use.', 'bgtfw' ),
		'section'     => 'bgtfw_footer_colors',
		'priority' => 10,
		'default'     => '',
		'choices'     => array(
			'colors' => $formatted_palette,
			'size' => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'type'        => 'bgtfw-palette-selector',
		'transport' => 'postMessage',
		'settings'    => 'bgtfw_footer_headings_color',
		'label' => esc_attr__( 'Headings Color', 'bgtfw' ),
		'section'     => 'bgtfw_footer_colors',
		'priority' => 20,
		'default'     => '',
		'choices'     => array(
			'colors' => $formatted_palette,
			'size' => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'type'        => 'bgtfw-palette-selector',
		'transport' => 'postMessage',
		'settings'    => 'bgtfw_footer_links',
		'label' => esc_attr__( 'Link Color', 'bgtfw' ),
		'section'     => 'bgtfw_footer_colors',
		'priority' => 30,
		'default'     => '',
		'choices'     => array(
			'colors' => $formatted_palette,
			'size' => $palette->get_palette_size( $formatted_palette ),
		),
		'sanitize_callback' => array( $sanitize, 'sanitize_palette_selector' ),
	),
	array(
		'label'       => __( 'Columns', 'bgtfw' ),
		'description' => __( 'Select the number of columns you wish to display on your blog page.', 'bgtfw' ),
		'type'        => 'number',
		'settings'    => 'bgtfw_pages_blog_blog_page_layout_columns',
		'priority'    => 1,
		'default'     => 1,
		'transport'   => 'postMessage',
		'choices'     => array(
			'min'  => 1,
			'max'  => 6,
			'step' => 1,
		),
		'section'     => 'bgtfw_pages_blog_blog_page_layout',
	),
	array(
		'type'        => 'switch',
		'settings'    => 'bgtfw_pages_blog_blog_page_layout_featimg',
		'label'       => esc_attr__( 'Featured Images', 'bgtfw' ),
		'description' => __( 'Display the featured image for posts in the full post content.', 'bgtfw' ),
		'section'     => 'bgtfw_pages_blog_blog_page_layout',
		'default'     => false,
		'priority'    => 45,
	),
	array(
		'type'        => 'radio',
		'settings' => 'bgtfw_pages_blog_blog_page_layout_content',
		'transport' => 'refresh',
		'label'       => esc_html__( 'Post Content Display', 'bgtfw' ),
		'priority'    => 40,
		'default'   => 'excerpt',
		'choices'     => array(
			'excerpt' => esc_attr__( 'Post Excerpt', 'bgtfw' ),
			'content' => esc_attr__( 'Full Content', 'bgtfw' ),
		),
		'section' => 'bgtfw_pages_blog_blog_page_layout',
	),
	array(
		'settings' => 'bgtfw_pages_blog_posts_layout_layout',
		'transport'   => 'postMessage',
		'label'       => esc_html__( 'Layout', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 40,
		'default'   => 'container',
		'choices'     => array(
			'container' => esc_attr__( 'Contained', 'bgtfw' ),
			'container-fluid' => esc_attr__( 'Full Width', 'bgtfw' ),
		),
		'section' => 'bgtfw_pages_blog_posts_layout',
	),
	array(
		'settings' => 'bgtfw_layout_blog',
		'label'       => esc_html__( 'Sidebar Display', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 10,
		'default'   => 'no-sidebar',
		'choices'     => array(),
		'section'     => 'bgtfw_pages_blog_posts_sidebar',
	),
	array(
		'settings' => 'bgtfw_blog_blog_page_settings',
		'label'       => esc_html__( 'Homepage Sidebar Display', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 10,
		'default'   => 'no-sidebar',
		'choices'     => array(),
		'section'     => 'bgtfw_blog_blog_page_settings',
	),
	array(
		'settings' => 'bgtfw_blog_layout',
		'transport'   => 'postMessage',
		'label'       => esc_html__( 'Design', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 40,
		'default'   => 'layout-1',
		'choices'     => array(
			'design-1' => esc_attr__( 'Design 1', 'bgtfw' ),
			'design-2' => esc_attr__( 'Design 2', 'bgtfw' ),
			'design-3' => esc_attr__( 'Design 3', 'bgtfw' ),
			'design-4' => esc_attr__( 'Design 4', 'bgtfw' ),
		),
		'section' => 'bgtfw_pages_blog_blog_page_layout',
	),
	array(
		'settings' => 'bgtfw_blog_blog_page_sidebar',
		'label'       => esc_html__( 'Homepage Sidebar Display', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 30,
		'default'   => 'no-sidebar',
		'choices'     => array(),
		'section'     => 'static_front_page',
		'active_callback' => function() {
			return get_option( 'show_on_front', 'posts' ) === 'posts' ? true : false;
		},
	),
	array(
		'setting' => 'bgtfw_blog_blog_page_sidebar2',
		'settings'    => 'bgtfw_blog_blog_page_sidebar',
		'label'       => esc_html__( 'Sidebar Options', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 10,
		'default'   => 'no-sidebar',
		'choices'     => array(),
		'section'     => 'bgtfw_blog_blog_page_panel_sidebar',
	),
	array(
		'settings' => 'bgtfw_layout_blog_layout',
		'transport'   => 'postMessage',
		'label'       => esc_html__( 'Homepage Blog Layout', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 40,
		'default'   => 'layout-1',
		'choices'     => array(
			'layout-1' => esc_attr__( 'Layout 1', 'bgtfw' ),
			'layout-2' => esc_attr__( 'Layout 2', 'bgtfw' ),
			'layout-3' => esc_attr__( 'Layout 3', 'bgtfw' ),
			'layout-4' => esc_attr__( 'Layout 4', 'bgtfw' ),
			'layout-5' => esc_attr__( 'Layout 5', 'bgtfw' ),
			'layout-6' => esc_attr__( 'Layout 6', 'bgtfw' ),
		),
		'section' => 'static_front_page',
		'active_callback' => function() {
			return get_option( 'show_on_front', 'posts' ) === 'posts' ? true : false;
		},
	),
	array(
		'settings' => 'bgtfw_layout_blog_layout',
		'transport'   => 'postMessage',
		'label'       => esc_html__( 'Layout', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 40,
		'default' => 'layout-1',
		'choices'     => array(
			'layout-1' => esc_attr__( 'Layout 1', 'bgtfw' ),
			'layout-2' => esc_attr__( 'Layout 2', 'bgtfw' ),
			'layout-3' => esc_attr__( 'Layout 3', 'bgtfw' ),
			'layout-4' => esc_attr__( 'Layout 4', 'bgtfw' ),
			'layout-5' => esc_attr__( 'Layout 5', 'bgtfw' ),
			'layout-6' => esc_attr__( 'Layout 6', 'bgtfw' ),
		),
		'section' => 'bgtfw_layout_blog',
	),
	array(
		'settings' => 'bgtfw_header_top_layouts',
		'transport'   => 'postMessage',
		'label'       => esc_html__( 'Layout', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 30,
		'default'   => 'layout-1',
		'choices'     => array(
			'layout-1' => esc_attr__( 'Layout 1', 'bgtfw' ),
			'layout-2' => esc_attr__( 'Layout 2', 'bgtfw' ),
			'layout-3' => esc_attr__( 'Layout 3', 'bgtfw' ),
			'layout-4' => esc_attr__( 'Layout 4', 'bgtfw' ),
			'layout-5' => esc_attr__( 'Layout 5', 'bgtfw' ),
			'layout-6' => esc_attr__( 'Layout 6', 'bgtfw' ),
		),
		'section'     => 'bgtfw_header_layout',
	),
	array(
		'settings' => 'header_container',
		'transport'   => 'postMessage',
		'label'       => esc_html__( 'Header Container', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 30,
		'default'   => '',
		'choices'     => array(
			'' => esc_attr__( 'Full Width', 'bgtfw' ),
			'container' => esc_attr__( 'Fixed Width', 'bgtfw' ),
		),
		'section'     => 'bgtfw_header_layout',
	),
	array(
		'settings' => 'bgtfw_footer_layouts',
		'transport'   => 'postMessage',
		'label'       => esc_html__( 'Layout', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 10,
		'default'   => 'layout-1',
		'choices'     => array(
			'layout-1' => esc_attr__( 'Layout 1', 'bgtfw' ),
			'layout-2' => esc_attr__( 'Layout 2', 'bgtfw' ),
			'layout-3' => esc_attr__( 'Layout 3', 'bgtfw' ),
			'layout-4' => esc_attr__( 'Layout 4', 'bgtfw' ),
			'layout-5' => esc_attr__( 'Layout 5', 'bgtfw' ),
			'layout-6' => esc_attr__( 'Layout 6', 'bgtfw' ),
			'layout-7' => esc_attr__( 'Layout 7', 'bgtfw' ),
			'layout-8' => esc_attr__( 'Layout 8', 'bgtfw' ),
		),
		'section'     => 'boldgrid_footer_panel',
	),
	array(
		'settings' => 'footer_container',
		'transport'   => 'postMessage',
		'label'       => esc_html__( 'Footer Container', 'bgtfw' ),
		'type'        => 'radio',
		'priority'    => 10,
		'default'   => '',
		'choices'     => array(
			'' => esc_attr__( 'Full Width', 'bgtfw' ),
			'container' => esc_attr__( 'Fixed Width', 'bgtfw' ),
		),
		'section'     => 'boldgrid_footer_panel',
	),
	array(
		'settings' => 'bgtfw_header_layout_position',
		'transport' => 'postMessage',
		'label' => __( 'Header Position', 'bgtfw' ),
		'type' => 'radio',
		'priority' => 10,
		'default' => 'header-top',
		'choices' => array(
			'header-top' => esc_attr__( 'Header on Top', 'bgtfw' ),
			'header-left' => esc_attr__( 'Header on Left', 'bgtfw' ),
			'header-right' => esc_attr__( 'Header on Right', 'bgtfw' ),
		),
		'section' => 'bgtfw_header_layout',
	),
);
