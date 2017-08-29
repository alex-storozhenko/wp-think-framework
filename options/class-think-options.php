<?php

if ( ! class_exists( 'Think_Options' ) ) {
	/**
	 * Options framework
	 *
	 * Class Think_Options
	 *
	 * @package wp-think-framework
	 */
	class Think_Options implements Think_Input_Initiator {
		use Think_Fields_Walker;

		/**
		 * @input_types:
		 *  checkbox,
		 *  color,
		 *  date,
		 *  image,
		 *  radio,
		 *  select,
		 *  text,
		 *  textarea,
		 *  tinyMCE
		 *
		 * @sanitize_callbacks:
		 *  text_input,
		 *  color_input,
		 *  url_input,
		 *  email_input,
		 *  textarea_input,
		 *  by_pattern_input, //if chosen it you need add sanitize_pattern(Regex value) to array of input
		 *  none_sanitize_input
		 *
		 * <code>
		 *[
		 *     //section_id in do_settings_fields( $slug, $section['id'] );
		 *     'social' => [
		 *          'title' //display name of section  => 'Social',
		 *          'fields' //array of fields => [
		 *              [
		 *                  //id is Required. Attention! id must always be unique, otherwise the result will be unexpected.
		 *                  'id'                => 'facebook',
		 *                  'label'             => 'Facebook',
		 *                  'type'              => 'text', //@see @input_types or wp-thinkframework/inputs classes
		 *                  'options'           => [], //additional options e.g for select [$title => $value]
		 *                  'show_in_rest'      => false,
		 *                  'description'       => '',
		 *                  'sanitize_callback' => 'url_input' @see @sanitize_callback or Think_Input_Sanitizer methods
		 *              ],
		 *              [
		 *                  'id'                => 'twitter',
		 *                  'label'             => 'Twitter',
		 *                  'type'              => 'text'
		 *              ],
		 *          ]
		 *     ],
		 *     'contacts' => [
		 *          'title'  => 'Contacts page',
		 *          'fields' => [
		 *              [
		 *                  'id'                => 'contacts_map_img',
		 *                  'label'             => 'Contacts Map',
		 *                  'type'              => 'image',
		 *                  'show_in_rest'      => false,
		 *                  'description'       => '',
		 *                  'sanitize_callback' => 'url_input'
		 *             ],
		 *             [
		 *                  'id'                => 'contacts',
		 *                  'label'             => 'Contacts',
		 *                  'type'              => 'tinyMCE',
		 *                  'options'           => [],
		 *                  'show_in_rest'      => false,
		 *                  'description'       => '',
		 *                  'sanitize_callback' => 'text_input'
		 *             ],
		 *          ]
		 *     ],
		 *];
		 *</code>
		 *
		 * @var array $structure
		 */
		protected $structure;

		/**
		 * Unique key for DB save or get group of options
		 *
		 * @var string $options_key
		 */
		protected $options_key;

		/**
		 * Slug of the menu section to which will
		 * be added a page with options
		 *
		 * @var string $parent_slug
		 */
		protected $parent_slug;

		/**
		 * Title for page with options
		 *
		 * @var string $title
		 */
		protected $title;

		/**
		 * Slug of page with options
		 *
		 * @var string $slug
		 */
		protected $slug;

		/**
		 * Think_Options constructor
		 * Register settings
		 *
		 * @param array $structure
		 * @param $title
		 * @param $parent_slug
		 * @param $options_key
		 */
		protected function __construct( array $structure, $title, $parent_slug, $options_key ) {
			$this->structure   = $structure;
			$this->title       = $title;
			$this->parent_slug = $parent_slug;
			$this->options_key = $options_key;
			$this->slug        = 'edit' . Think_Helper::str_snake_to_kebab( $this->options_key ) . '-theme-options';

			add_action( 'admin_enqueue_scripts', function () {
				$this->enqueue_assets();
			} );

			add_action( 'admin_menu', function () {
				$this->options_page();
			} );

			add_action( 'admin_init', function () {
				$this->add_settings();
			} );
		}

		/** Add js and css */
		protected function enqueue_assets() {
			wp_enqueue_style( 'options_style', THINK_FRAMEWORK_URI . '/options/assets/css/style.css', array(), THINK_FRAMEWORK_VERSION );
			wp_enqueue_script( 'options_script', THINK_FRAMEWORK_URI . '/options/assets/js/theme.options.js', array( 'jquery' ), THINK_FRAMEWORK_VERSION, true );
		}

		/** Create theme menu item function */
		protected function options_page() {
			add_submenu_page(
				$this->parent_slug,
				$this->title,
				$this->title,
				'manage_options',
				$this->slug,
				function () {
					return Think_Options_Page_Template::render( array(
						'slug'        => $this->slug,
						'options_key' => $this->options_key
					) );
				}
			);
		}

		/**
         * @inheritdoc
         *
		 * Return data from DB by input_id
		 *
		 * @param int|null $input_id
		 *
		 * @return mixed
		 */
		public function get_data( $input_id = null ) {
			if ( ! $input_id ) {
				return get_option( $this->options_key );
			}

			return ! isset( get_option( $this->options_key )[ $input_id ] ) ? '' : get_option( $this->options_key )[ $input_id ];
		}

		/**
         * @inheritdoc
         *
		 * Get key ($this->options_key)
		 *
		 * @return mixed
		 */
		public function get_key() {
			return $this->options_key;
		}

		/**
		 * Callback admin_init()
		 *
		 * Register all settings
		 */
		protected function add_settings() {
			foreach ( $this->structure as $section_id => $section ) {
				add_settings_section( $section_id, $section['title'], null, $this->slug );

				$fields = $this->get_fields( $section_id );

				foreach ( $fields as $field ) {
					add_settings_field( $field['id'], $field['label'], function ( $field ) {
						$input = Think_Input_Factory::make( $this, $field );

						return $input->render();
					}, $this->slug, $section_id, $field );

					$this->register_setting( $section_id, $field );
				}
			}
		}

		/**
		 * Register setting
		 *
		 * @param $section_id
		 * @param array $field
		 */
		protected function register_setting( $section_id, array $field ) {
			$description  = ( ! array_key_exists( 'description', $field ) ) ? '' : $field['description'];
			$show_in_rest = ( ! array_key_exists( 'show_in_rest', $field ) ) ? false : $field['show_in_rest'];

			register_setting( $this->options_key . '_' . $section_id, $this->options_key, array(
				'description'       => $description,
				'sanitize_callback' => function ( $values ) {
					return Think_Input_Sanitizer::sanitize( $values, $this->get_fields() );
				},
				'show_in_rest'      => $show_in_rest,
			) );
		}

		/**
		 * Options Factory
		 *
		 * Create page with custom options
		 *
		 * @param string $options_key @see Think_Options::$options_key
		 *
		 * @param array $structure @see Think_Options::$structure
		 * @param string|null $parent_slug (default options.php)
		 * @param string $title
		 *
		 * @return static
		 */
		public static function create( $structure, $title, $parent_slug = 'options-general.php', $options_key = '_think_options_general' ) {
			return new static( $structure, $title, $parent_slug, $options_key );
		}

		/**
		 * Get options
		 *
		 * @param $options_key
		 * @param null $input_id
		 *
		 * @return mixed
		 */
		public static function get_options( $options_key, $input_id = null ) {
			if ( ! $input_id ) {
				return get_option( $options_key );
			}

			return ! isset( get_option( $options_key )[ $input_id ] ) ? '' : get_option( $options_key )[ $input_id ];
		}
	}
}