<?php

if ( ! class_exists( 'Think_Customizer' ) ) {
	/**
	 * Customizer framework
	 *
	 * Class Think_Customizer
	 *
	 * @package wp-think-framework
	 */
	class Think_Customizer {

		/**
		 * Code example:
		 *
		 * [
		 *   "data" => [
		 *      [
		 *          "section" => [
		 *              "id" => "banner",
		 *              "title" => "Banner",
		 *              "priority" => 1,
		 *              "controls" => [
		 *                  [
		 *                      "id" => "banner_title",
		 *                      "label" => "Banner title",
		 *                      "default" => "We support your WordPress, and you can trust", //(optional)
		 *                      "type" => "input" //(optional, can be image, textarea, checkbox, radio, select )
		 *                  ]
		 *              ]
		 *          ],
		 *      ]
		 *   ]
		 * ]
		 *
		 * @var array $structure
		 */
		protected $structure;

		/**
		 * Think_Customizer constructor
		 *
		 * @param $structure
		 */
		protected function __construct( $structure ) {
			$this->structure = json_decode( json_encode( $structure, false ) );

			add_action( 'customize_register', array( $this, 'customize_register' ) );
			add_action( 'customize_preview_init', array( $this, 'customize_preview_init' ) );
		}

		/**
		 * Return theme option, replace with default value if empty
		 *
		 * @param $key
		 * @param string $default
		 *
		 * @return string
		 */
		public static function get_customizer_value( $key, $default = '' ) {
			$mod = get_theme_mod( $key );

			return ( ! $mod ) ? $default : $mod;
		}


		/**
		 * Customizer Factory
		 *
		 * @param array $structure @see Think_Customizer::$structure
		 *
		 * @return static
		 */
		public static function create( array $structure ) {
			return new static( $structure );
		}

		/** Enqueue assets */
		public function customize_preview_init() {
			wp_enqueue_script( 'theme-customizer', THINK_FRAMEWORK_URI . 'customizer/assets/js/customizer.js', [], THINK_FRAMEWORK_VERSION );
		}

		/**
		 * Register customizer elem's
		 *
		 * @param WP_Customize_Manager $wp_customize
		 */
		public function customize_register( \WP_Customize_Manager $wp_customize ) {

			if ( ! empty( $this->structure->data ) ) {
				foreach ( $this->structure->data as $section ) {
					$section = $section->section;

					$wp_customize->add_section( $section->id, array(
						"title"    => $section->title,
						"priority" => ( ! empty( $section->priority ) ) ? $section->priority : 1
					) );

					if ( ! empty( $section->controls ) ) {
						foreach ( $section->controls as $setting ) {
							$default = ( ! empty( $setting->default ) ) ? $setting->default : '';
							$type    = ( ! empty( $setting->type ) ) ? $setting->type : 'input';

							$wp_customize->add_setting( $setting->id, array(
								"default"   => $default,
								"transport" => "postMessage",
							) );

							$wp_customize->get_setting( $setting->id )->transport = 'postMessage';

							$class_args = array(
								"label"    => $setting->label,
								"section"  => $section->id,
								"settings" => $setting->id,
								"type"     => $type,
							);

							$wp_customize->add_control( $this->get_control( $wp_customize, $setting->id, $class_args, $setting->type ) );
						}
					}
				}
			}
		}

		/**
		 * Get controls
		 *
		 * @param $wp_customize
		 * @param $setting_id
		 * @param $class_args
		 * @param string $type
		 *
		 * @return WP_Customize_Control|WP_Customize_Image_Control
		 */
		protected function get_control( $wp_customize, $setting_id, $class_args, $type = 'input' ) {

			switch ( $type ) {
				case 'image':
					return new WP_Customize_Image_Control( $wp_customize, $setting_id, $class_args );
					break;

				default:
					return new WP_Customize_Control( $wp_customize, $setting_id, $class_args );
					break;
			}
		}
	}
}