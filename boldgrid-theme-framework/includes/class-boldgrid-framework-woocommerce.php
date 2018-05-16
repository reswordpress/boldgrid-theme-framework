<?php
/**
 * Class: BoldGrid_Framework_Woocommerce
 *
 * This is where all wooCommerce specific functionality is manipulated, outside
 * of custom templates used by parent themes.
 *
 * @since      1.4.1
 * @package    Boldgrid_Framework
 * @author     BoldGrid <support@boldgrid.com>
 * @link       https://boldgrid.com
 */

/**
 * Class: BoldGrid_Framework_Woocommerce
 *
 * This is where all wooCommerce specific functionality is manipulated, outside
 * of custom templates used by parent themes.
 *
 * @since      1.4.1
 */
class BoldGrid_Framework_Woocommerce {

	/**
	 * The BoldGrid Theme Framework configurations.
	 *
	 * @since     1.4.1
	 * @access    protected
	 * @var       string     $configs       The BoldGrid Theme Framework configurations.
	 */
	protected $configs;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param     string $configs       The BoldGrid Theme Framework configurations.
	 * @since     1.4.1
	 */
	public function __construct( $configs ) {
		$this->configs = $configs;
	}

	/**
	 * Filter add_to_cart_url.
	 *
	 * This is responsible for filtering the add to cart buttons  used throughout
	 * wooCommerce and placing our button classes on them.
	 *
	 * @global $product wooCommerce global product info.
	 *
	 * @param  string $link Markup for the link to place on wooCommerce pages.
	 *
	 * @return string $link Markup to use for add to cart buttons in wooCommerce.
	 */
	public function buttons( $link ) {
		global $product;
		$link = sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $quantity ) ? $quantity : 1 ),
			esc_attr( $product->get_id() ),
			esc_attr( $product->get_sku() ),
			esc_attr( isset( $class ) ? $class : 'btn button-primary' ),
			esc_html( $product->add_to_cart_text() )
		);

		return $link;
	}

	/**
	 * Set the color of the Sale! indicator.
	 *
	 * @param string     $text String being filtered.
	 * @param WC_Post    $post WooCommerce Post ID.
	 * @param WC_Product $_product WooCommerce Product ID.
	 *
	 * @return String Markup that is being returned to the filter.
	 */
	public function woocommerce_custom_sale_text( $text, $post, $_product ) {
		return '<span class="onsale color2-background-color color-2-text-contrast">Sale!</span>';
	}

	/**
	 * Add custom argument to variation dropdowns.
	 *
	 * @param  Array $args Arguments for variation dropdown filter.
	 *
	 * @return Array $args Arguments to apply to variation dropdown filter.
	 */
	public function variation_dropdown( $args ) {
		$args['class'] = 'form-control';
		return $args;
	}

	/**
	 * Modify WooCommerce customizer controls.
	 *
	 * @since 2.0.0
	 *
	 * @param WP_Customize $wp_customize WP_Customizer object.
	 */
	public function customizer( $wp_customize ) {
		delete_site_option( 'woocommerce_single_image_width' );
		$wp_customize->remove_control( 'woocommerce_single_image_width' );
	}

	/**
	 * Adds a container wrapper to woocommerce pages.
	 *
	 * @since 2.0.0
	 */
	public function add_container_open() {
		$classes = array( get_theme_mod( 'woocommerce_container', 'container' ) );
		$classes = apply_filters( 'bgtfw_woocommerce_wrapper_classes', $classes );
		echo '<div class="' . esc_attr( implode( ' ', $classes ) ) . '"><div>';
	}

	/**
	 * Closes the wrapper div on woocommerce pages.
	 *
	 * @since 2.0.0
	 */
	public function add_container_close() {
		echo '</div>';
	}

	/**
	 * Checks if on woocommerce page.
	 *
	 * @since 2.0.0
	 *
	 * @return bool Is current page a woocommerce page.
	 */
	public function is_woocommerce_page() {
		return ( bool ) ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) || array_filter(
			array(
				'woocommerce_shop_page_id',
				'woocommerce_terms_page_id',
				'woocommerce_cart_page_id',
				'woocommerce_checkout_page_id',
				'woocommerce_pay_page_id',
				'woocommerce_thanks_page_id',
				'woocommerce_myaccount_page_id',
				'woocommerce_edit_address_page_id',
				'woocommerce_view_order_page_id',
				'woocommerce_change_password_page_id',
				'woocommerce_logout_page_id',
				'woocommerce_lost_password_page_id',
			),
			function( $id ) {
				return get_the_ID() == get_option( $id , 0 );
			}
		);
	}

	/**
	 * Adds select2 styles to match our theme.
	 *
	 * Woocommerce adds select to for their dropdowns, which creates a better
	 * user experience overall.  The styles conflict with the native styles of
	 * bootstrap, so we add our bootstrap select2 style conditionally if woocommerce
	 * class is present, and we are on the checkout page.  This needs to be enqueued
	 * after the initial select2 styles, so we require that as a dependancy.
	 *
	 * @since 1.4.1
	 */
	public function select2_style() {
		if ( class_exists( 'woocommerce' ) ) {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			if ( is_woocommerce() ) {
				$style = '.palette-primary.woocommerce ul.products li.product a.btn, .palette-primary.woocommerce-page ul.products li.product a.btn { max-width: ' . get_site_option( 'woocommerce_thumbnail_image_width', 300 ) . 'px;}';
				wp_add_inline_style( 'woocommerce-layout', $style );
			}

			/**
			 * Only needed in checkout pages, or if the use is logged in to account.
			 */
			if ( is_checkout() || ( is_account_page() && is_user_logged_in() ) ) {
				wp_enqueue_style(
					'select2-bootstrap-css',
					$this->configs['framework']['css_dir'] . 'select2-bootstrap/select2-bootstrap' . $suffix . '.css',
					array( 'select2' ),
					'1.4.6'
				);
			}

			/**
			 * Only needed on cart and product pages.
			 */
			if ( is_product() || is_cart() ) {
				wp_enqueue_script(
					'bgtfw-woo-quantity',
					$this->configs['framework']['js_dir'] . 'woocommerce/quantity' . $suffix . '.js',
					array( 'jquery' ),
					'1.4.6'
				);
			}

			/**
			 * Only needed on the single-product pages.
			 */
			if ( is_product() ) {
				wp_enqueue_script(
					'bgtfw-woo-tabs',
					$this->configs['framework']['js_dir'] . 'woocommerce/tabs' . $suffix . '.js',
					array( 'jquery' ),
					'1.4.6'
				);
			}

			/**
			 * Only needed if we're in account section, the user isn't logged in,
			 * and the site owner has enabled user registration.
			 */
			if ( is_account_page() && ! is_user_logged_in() && get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
				wp_enqueue_script(
					'bgtfw-woo-user-login',
					$this->configs['framework']['js_dir'] . 'woocommerce/user-login' . $suffix . '.js',
					array( 'jquery' ),
					'1.4.6'
				);
			}

			if ( is_customize_preview() && is_store_notice_showing() ) {
				$css = '.woocommerce-store-notice, p.demo_store { display: flex !important; } .header-fixed.header-top.woocommerce-demo-store { margin-top: 57px; }';
				wp_add_inline_style( 'customize-preview', $css );
			}
		}
	}

	/**
	 * Adding .form-control for input elements in wooCommerce.
	 *
	 * The input elements used throughout wooCommerce should inherit
	 * the set bootstrap styles we use throughout our themes.
	 *
	 * @param Array  $args Arguments to filter for form attributes.
	 * @param string $key Not in use.
	 * @param string $value Not in use.
	 *
	 * @return Array $args Our new arguments to apply to forms.
	 */
	public function wc_form_field_args( $args, $key, $value = null ) {
		/**
		 * Look for the various types of items wooCommerce uses, and tap into the
		 * filter to conditoinally apply our required classes to match bootstrap's
		 * expected structure.
		 */
		switch ( $args['type'] ) {
			/**
			 * Targets all select input type elements, except the country and
			 * state select input types.
			 */
			case 'select' :
				// Add a class to the field's html element wrapper - woocommerce input types (fields) are often wrapped within a <p></p> tag.
				$args['class'][] = 'form-group';
				// Add a class to the form input itself.
				$args['input_class'] = array(
					'form-control',
					'input-lg',
				);
				$args['label_class'] = array(
					'control-label',
				);
				// Add custom data attributes to the form input itself.
				$args['custom_attributes'] = array(
					'data-plugin' => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden' => 'true',
				);
				break;

			/**
			 * By default WooCommerce will populate a select with the country
			 * names - $args defined for this specific input type targets only
			 * the country select element.
			 */
			case 'country' :
				$args['class'][] = 'form-group single-country';
				// Add class to the form input itself.
				$args['input_class'] = array(
					'form-control',
					'input-lg',
				);
				$args['label_class'] = array(
					'control-label',
				);
				$args['custom_attributes'] = array(
					'data-plugin' => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden' => 'true',
				);
				break;

			/**
			 * By default WooCommerce will populate a select with state names -
			 * $args defined for this specific input type targets only the country
			 * select element.
			 */
			case 'state' :
				// Add class to the field's html element wrapper.
				$args['class'][] = 'form-group';
				// Add class to the form input itself.
				$args['input_class'] = array(
					'form-control',
					'input-lg',
				);
				$args['label_class'] = array(
					'control-label',
				);
				$args['custom_attributes'] = array(
					'data-plugin' => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden' => 'true',
				);
				break;

			case 'password' :
			case 'text' :
			case 'email' :
			case 'tel' :
			case 'number' :
				$args['class'][] = 'form-group';
				$args['input_class'] = array(
					'form-control',
					'input-lg',
				);
				$args['label_class'] = array(
					'control-label',
				);
				break;

			case 'textarea' :
				$args['input_class'] = array(
					'form-control',
					'input-lg',
				);
				$args['label_class'] = array(
					'control-label',
				);
				break;

			case 'checkbox' :
				break;

			case 'radio' :
				break;

			default :
				$args['class'][] = 'form-group';
				$args['input_class'] = array(
					'form-control',
					'input-lg',
				);
				$args['label_class'] = array(
					'control-label',
				);
				break;
		}

		return $args;
	}

	/**
	 * Filter for wooCommerce Breadcrumbs.
	 *
	 * We use this to apply some of our color classes to the breadcrumb output,
	 * and to style the Home URL as a Home icon.
	 *
	 * @return Array The new breadcrumb arguments to apply to filter.
	 */
	public function breadcrumbs() {
		$home_url = get_home_url();
		return array(
			'delimiter'   => '',
			'wrap_before' => '<ol class="breadcrumb color1-background-color">
				<li><a href="' . apply_filters( 'woocommerce_breadcrumb_home_url', $home_url ) . '"><i class="fa fa-home"></i><span class="sr-only">' . _x( 'Home', 'breadcrumb', 'woocommerce' ) . '</span></a></li>',
			'wrap_after'  => '</ol>',
			'before'      => '<li>',
			'after'       => '</li>',
			'home'        => '',
		);
	}

	/**
	 * Suppress template outdated messages if user doesn't have
	 * debugging turned on.
	 *
	 * @since 1.5.0
	 */
	public function remove_template_warnings() {
		if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
			if ( class_exists( 'WC_Admin_Notices' ) ) {

				// Remove the "you have outdated template files" nag.
				WC_Admin_Notices::remove_notice( 'template_files' );
			}
		}
	}
}
