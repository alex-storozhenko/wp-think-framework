<?php

if ( ! class_exists( 'Think_Customizer' ) ) {
	/**
	 * Class Think_Customizer
	 *
	 * Implements standard WP Customizer functionality
	 */
	class Think_Customizer {

		/**
		 * Json structure
		 *
		 * @var array|mixed|object
		 */
		protected $structure;

		/**
		 * Think_Customizer constructor.
		 *
		 * @param $datafile
		 */
		final protected function __construct( $datafile ) {
			if ( is_readable( $datafile ) ) {
				$this->structure = json_decode( file_get_contents( $datafile ) );
			}

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
		public static function mod( $key, $default = '' ) {
			$mod = get_theme_mod( $key );

			return ( ! empty( $mod ) ) ? $mod : $default;
		}


		/**
		 * Create
		 *
		 * path to json file with structure e.g.
		 * customizer.json must have same structure:
		 *
		 * {
		 *      "data": [
		 *          {
		 *              "section": {
		 *              "id": "banner",
		 *              "priority": 1,
		 *              "controls": [
		 *                  {
		 *                      "id": "banner_title",
		 *                      "label": "Banner title",
		 *                      "default": "We support your WordPress, and you can trust" (optional)
		 *                      "type": "image" (optional, can be image or textarea)
		 *                  },
		 *                  ...
		 *                  ]
		 *              },
		 *          ...
		 *          }
		 *      ]
		 * }
		 *
		 * @param $datafile
		 */
		public static function create( $datafile ) {
			new static( $datafile );
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

							$classArgs = array(
								"label"    => $setting->label,
								"section"  => $section->id,
								"settings" => $setting->id,
								"type"     => $type,
							);

							$wp_customize->add_control( self::get_control( $wp_customize, $setting->id, $classArgs, $setting->type ) );
						}
					}
				}
			}
		}

		/**
		 * Get controls
		 *
		 * @param $wp_customize
		 * @param $settingId
		 * @param $classArgs
		 * @param string $type
		 *
		 * @return WP_Customize_Control|WP_Customize_Image_Control
		 */
		protected function get_control( $wp_customize, $settingId, $classArgs, $type = 'input' ) {

			switch ( $type ) {
				case 'image':
					return new \WP_Customize_Image_Control( $wp_customize, $settingId, $classArgs );
					break;

				default:
					return new \WP_Customize_Control( $wp_customize, $settingId, $classArgs );
					break;
			}
		}
	}
}