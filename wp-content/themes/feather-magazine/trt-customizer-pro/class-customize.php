<?php
/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class feather_magazine_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
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

		// Load custom sections.
		require_once( trailingslashit( get_template_directory() ) . 'trt-customizer-pro/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'feather_magazine_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new feather_magazine_Customize_Section_Pro(
				$manager,
				'feather_magazine',
				array(
					'title'    => esc_html__( 'Pro Version', 'feather-magazine' ),
					        'priority'   => 0,

					'pro_text' => esc_html__( 'View All Features',         'feather-magazine' ),
					'pro_url'  => 'http://admirablethemes.com/feather-mag/'
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'feather-magazine-customize-controls', trailingslashit( get_template_directory_uri() ) . 'trt-customizer-pro/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'feather-magazine-customize-controls', trailingslashit( get_template_directory_uri() ) . 'trt-customizer-pro/customize-controls.css' );
	}
}

// Doing this customizer thang!
feather_magazine_Customize::get_instance();
