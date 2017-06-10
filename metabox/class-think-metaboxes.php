<?php

if ( ! class_exists( 'Think_Metaboxes' ) ) {
	/**
	 * Metabox framework
	 *
	 * Class Think_Metaboxes
	 *
	 * @package wp-think-framework
	 */
	class Think_Metaboxes implements Think_Input_Initiator {
		use Think_Can_Verify_Nonce, Think_Fields_Walker;

		/**
		 * @input_types:
		 *  checkbox,
		 *  color,
		 *  col,
		 *  date,
		 *  image,
		 *  nonce,
		 *  radio,
		 *  row,
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
		 *  //metabox_id
		 *  'social'   => [
		 *      'title'//display name of metabox => 'Social',
		 *      'fields'//array of fields => [
		 *          [
		 *              //id is Required. Attention! id must always be unique, otherwise the result will be unexpected.
		 *              'id'                => 'facebook',
		 *              'label'             => 'Facebook',
		 *              'type'              => 'text',//@see @input_types or wp-thinkframework/inputs classes
		 *              'options'           => [], //additional options e.g for select [$title => $value]
		 *              'show_in_rest'      => false,
		 *              'sanitize_callback' => 'url_input' @see @sanitize_callback or Think_Input_Sanitizer methods
		 *          ],
		 *          [
		 *              'id'                => 'twitter',
		 *              'label'             => 'Twitter',
		 *              'type'              => 'color',
		 *              'show_in_rest'      => false,
		 *              'description'       => '',
		 *              'sanitize_callback' => 'color_input'
		 *          ],
		 *      ]
		 *  ],
		 *  'contacts' => [
		 *      'title'  => 'Contacts page',
		 *      'fields' => [
		 *          [
		 *              'type'   => 'row',
		 *              'fields' => [
		 *                  [
		 *                      'type'   => 'col',
		 *                      'width'  => 3,
		 *                      'fields' => [
		 *                          [
		 *                              'id'           => 'contacts_map_location',
		 *                              'label'        => 'Contacts Map Location',
		 *                              'type'         => 'image',
		 *                              'show_in_rest' => true,
		 *                          ],
		 *                      ],
		 *                  ],
		 *                  [
		 *                      'type'   => 'col',
		 *                      'width'  => 3,
		 *                      'fields' => [
		 *                          [
		 *                              'id'           => 'date',
		 *                              'label'        => 'Date',
		 *                              'type'         => 'date',
		 *                              'show_in_rest' => true,
		 *                          ],
		 *                      ]
		 *                  ],
		 *                  [
		 *                      'type'   => 'col',
		 *                      'width'  => 3,
		 *                      'fields' => [
		 *                          [
		 *                              'id'                => 'contacts',
		 *                              'label'             => 'Contacts',
		 *                              'type'              => 'textarea',
		 *                              'show_in_rest'      => true,
		 *                              'sanitize_callback' => 'textarea_input'
		 *                          ],
		 *                      ]
		 *                  ]
		 *              ],
		 *          ],
		 *      ]
		 *  ],
		 *];
		 * </code>
		 *
		 * @var array $structure
		 */
		protected $structure;

		/**
		 * Where will display registered metabox
		 * e.g:
		 *  normal, advanced or side.
		 *
		 * @var string $context
		 */
		protected $context;

		/**
		 * The name of the screen for which the block is added. See get_current_screen (). For example, it can be:
		 * For post_types: post, page, link, attachment, or custom_post_type
		 * Or for other pages of admin: link, comment.
		 * You can specify several types in an array: array('post', 'page'). version 4.4. or later
		 *
		 * @var string|array $screen
		 */
		protected $screen;

		/**
		 * The priority of the block to display above or below the remaining blocks: high or low.
		 *
		 * @var string $priority
		 */
		protected $priority;

		/**
		 * Unique key for DB save or get meta data
		 *
		 * @var string $meta_key
		 */
		protected $meta_key;

		/**
		 * Generate unique key for registered nonce field protection
		 *
		 * @var string $nonce_key
		 */
		protected $nonce_key;

		/**
		 * Think_Metaboxes constructor
		 * Register metaboxes
		 *
		 * @param $screen
		 * @param $structure
		 * @param $context
		 * @param string $priority
		 * @param string $meta_key
		 */
		protected function __construct( $screen, $structure, $context, $priority, $meta_key ) {
			$this->post_type = $screen;
			$this->structure = $structure;
			$this->place     = $context;
			$this->priority  = $priority;
			$this->meta_key  = $meta_key;
			$this->nonce_key = $this->screen . $this->meta_key . uniqid( '_' );

			add_action( 'add_meta_boxes', function () {
				$this->register_metaboxes();
			} );

			add_action( 'save_post', function ( $post_id ) {
				$this->save( $post_id );
			} );
		}

		/**
		 * Get data from DB
		 *
		 * @param $input_id
		 * @param bool $single Optional. Whether to return a single value. Default false.
		 *
		 * @return mixed
		 */
		public function get_data( $input_id, $single = true ) {
			global $post;

			return ( ! empty( get_post_meta( $post->ID, $this->meta_key, $single )[ $input_id ] ) ) ? get_post_meta( $post->ID, $this->meta_key, $single )[ $input_id ] : '';
		}

		/**
		 * Get meta_key
		 *
		 * @return string
		 */
		public function get_key() {
			return $this->meta_key;
		}

		/**
		 * Get nonce_key
		 *
		 * @return string
		 */
		public function get_nonce_key() {
			return $this->nonce_key;
		}

		/**
		 * Get fields
		 *
		 * @param null $metabox_id
		 *
		 * @return bool|array
		 */
		public function get_fields( $metabox_id = null ) {
			$fields = array();

			if ( $metabox_id ) {
				$fields = $this->walk_fields( $this->structure[ $metabox_id ]['fields'] );
			} else {
				foreach ( $this->structure as $section_id => $section ) {
					$fields = array_merge( $fields, $this->walk_fields( $section['fields'] ) );
				}
			}

			return $fields;
		}

		/**
		 * Add metabox logic
		 *
		 * @param string $id
		 * @param string $title
		 * @param array $fields
		 */
		protected function add_metabox( $id, $title, $fields ) {
			add_meta_box( $id, $title, function () use ( $fields ) {
				if ( $fields ) {
					foreach ( $fields as $field ) {
						( Think_Input_Factory::make( $this, $field ) )->render();
					}
				}
			}, $this->post_type, $this->place, $this->priority );
		}

		/**
		 * Callback add_metaboxes
		 *
		 * register metabox
		 */
		protected function register_metaboxes() {
			foreach ( (array) $this->structure as $metabox_id => $metabox ) {
				$this->add_metabox( $metabox_id, $metabox['title'], $metabox['fields'] );
			}
		}

		/**
		 * Save meta
		 *
		 * @param int $post_id
		 *
		 * @return int
		 */
		protected function save( $post_id ) {
			$meta = ( empty( $_POST[ $this->meta_key ] ) ? array() : $_POST[ $this->meta_key ] );

			if ( ! $meta ||
			     ! current_user_can( 'edit_pages' ) ||
			     defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
			) {
				return $post_id;
			}

			if ( ! empty( $meta[ $this->nonce_key ] ) ) {
				if ( ! $this->verify_nonce( $meta[ $this->nonce_key ], $this->nonce_key ) ) {
					return $post_id;
				}

				unset( $meta[ $this->nonce_key ] );
			}

			$sanitized_meta = Think_Input_Sanitizer::sanitize( $meta, $this->get_fields() );

			return update_post_meta( $post_id, $this->meta_key, $sanitized_meta );
		}

		/**
		 * Metabox factory
		 *
		 * @param $screen @see Think_Metaboxes::$screen
		 * @param $structure @see Think_Metaboxes::$structure
		 * @param $context @see Think_Metaboxes::$context
		 * @param string $priority @see Think_Metaboxes::$priority
		 * @param string $meta_key @see Think_Metaboxes::$meta_key
		 *
		 * @return static
		 */
		public static function create( $screen, $structure, $context = 'normal', $priority = 'default', $meta_key = '_think_meta' ) {
			return new static( $screen, $structure, $context, $priority, $meta_key );
		}

		/**
		 * render meta value from unserialized meta
		 *
		 * @param string $key in get_post_meta() unserialized array
		 * @param array $meta After unserialize get_post_meta()
		 * @param string $default Default value
		 *
		 * @return string
		 */
		public static function render_value_from_unserialized_meta( $key, $meta, $default = '' ) {
			return Think_Helper::str_render_from_array( $key, $meta, $default );
		}

		/**
		 * Convert string to array from unserialized meta
		 *
		 * @param $key
		 * @param $meta
		 * @param string $delimiter
		 *
		 * @return array
		 */
		public static function convert_str_from_unserialized_meta_to_array( $key, $meta, $delimiter = ',' ) {
			if ( empty( $meta[ $key ] ) || ! strpos( $meta[ $key ], $delimiter ) ) {
				return array( $meta[ $key ] );
			}

			return explode( $delimiter, $meta[ $key ] );
		}
	}
}