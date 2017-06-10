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
			$this->structure = $structure;

			add_action( 'customize_register', function ( $wp_customize ) {
				$this->customize_register( $wp_customize );
			} );

			add_action( 'customize_preview_init', function () {
				$this->js_for_preview();
			} );
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
		protected function js_for_preview() {
			wp_enqueue_script( 'wp-think-framework-customizer', THINK_FRAMEWORK_URI . '/customizer/assets/js/customizer.preview.js', array(
				'jquery',
				'customize-preview'
			), THINK_FRAMEWORK_VERSION, true );

			wp_localize_script( 'wp-think-framework-customizer', Think_Helper::str_snake_to_camel( get_class( $this ) ), array(
				'structure' => $this->structure,
			) );
		}

		/**
		 * Register customizer elem's
		 *
		 * @param WP_Customize_Manager $wp_customize
		 */
		protected function customize_register( \WP_Customize_Manager $wp_customize ) {

			if ( ! empty( $this->structure ) ) {
				foreach ( $this->structure as $section ) {

					$wp_customize->add_section( $section['id'], array(
						'title'    => $section['title'],
						'priority' => ( ! empty( $section['priority'] ) ) ? $section['priority'] : 1
					) );

					if ( ! empty( $section['controls'] ) ) {
						$firstly = true;

						foreach ( $section['controls'] as $setting ) {
							$default = ( empty( $setting['default'] ) ) ? '' : $setting['default'];
							$type    = ( ! empty( $setting['type'] ) ) ? $setting['type'] : 'input';

							$wp_customize->add_setting( $setting['id'], array(
								'default' => $default,
							) );

							$wp_customize->get_setting( $setting['id'] )->transport = 'postMessage';

							$class_args = array(
								'label'    => $setting['label'],
								'section'  => $section['id'],
								'settings' => $setting['id'],
								'type'     => $type,
							);

							if ( $type === 'cropped_image' ) {
								$class_args = array_merge( $class_args, array(
									'width'  => ( empty( $setting['width'] ) ) ? 512 : $setting['width'],
									'height' => ( empty( $setting['height'] ) ) ? 512 : $setting['height']
								) );
							} elseif ( $type === 'radio' ) {
								$class_args = array_merge( $class_args, array(
									'choices' => ( empty( $setting['choices'] ) ) ? array() : $setting['choices']
								) );
							}

							$wp_customize->add_control( $this->get_control( $wp_customize, $setting['id'], $class_args, $type ) );
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

				case 'cropped_image':
					return new WP_Customize_Cropped_Image_Control( $wp_customize, $setting_id, $class_args );
					break;

				case 'color':
				case 'background_color':
					return new WP_Customize_Color_Control( $wp_customize, $setting_id, $class_args );
					break;

				case 'tinyMCE':
					return new Think_Customize_TinyMCE_Control( $wp_customize, $setting_id, $class_args );
					break;

				default:
					return new WP_Customize_Control( $wp_customize, $setting_id, $class_args );
					break;
			}
		}
	}
}