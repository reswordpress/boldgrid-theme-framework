<?php
/**
 * Boldgrid Customizer Help Panel.
 *
 * @since  1.0.0
 * @access public
 */
final class Boldgrid_Framework_Customizer_Help_Overlay {

	/**
	 * The BoldGrid Theme Framework configurations.
	 *
	 * @since     1.0.0
	 * @access    protected
	 * @var       array     $configs The BoldGrid Theme Framework configurations.
	 */
	protected $configs;

	/**
	 * Initialize class and set class properties.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function __construct( $configs ) {
		$this->configs = $configs;
	}


	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Register custom section types.
		$manager->register_section_type( 'Boldgrid_Framework_Customizer_Help_Overlay_Section' );

		// Register sections.
		$manager->add_section(
			new Boldgrid_Framework_Customizer_Help_Overlay_Section(
				$manager,
				'boldgrid_customizer_help',
				array(
					'title'    => esc_html__( 'Help', 'bgtfw' ),
				)
			)
		);
	}

	/**
	 * Loads JS for control.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {
		wp_enqueue_script( 'boldgrid-customizer-help-overlay-controls', $this->configs['framework']['js_dir'] . 'customizer/help-overlay.js', array( 'customize-controls' ) );
	}
}
