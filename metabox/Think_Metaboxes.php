<?php

if ( ! class_exists( 'Think_Metaboxes' ) ) {
	/**
	 * Metabox manager
	 *
	 * Class Think_Metaboxes
	 */
	class Think_Metaboxes {

		/** @var string $placement */
		protected $placement = '';

		/** @var string $post_type */
		protected $post_type = '';

		/**
		 * Think_Metaboxes constructor
		 *
		 * @param string $post_type
		 * @param string $place
		 */
		final protected function __construct( $post_type, $place ) {
			$this->placement = $place;
			$this->post_type = $post_type;

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		}

		/** Add js and css */
		public function enqueue_assets() {
			wp_enqueue_media();
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'metabox_style', THINK_FRAMEWORK_URI . '/metabox/assets/css/metabox.css', [], THINK_FRAMEWORK_VERSION );
			wp_enqueue_script( 'metabox_media_uploader', THINK_FRAMEWORK_URI . '/metabox/assets/js/media.uploader.js', [ 'jquery' ], THINK_FRAMEWORK_VERSION );
		}

		/**
		 * Return current place
		 *
		 * @return string $placement
		 */
		public function get_place() {
			return $this->placement;
		}

		/**
		 * Return current post type
		 *
		 * @return string $post_type
		 */
		public function get_post_type() {
			return $this->post_type;
		}

		/**
		 * Register metabox
		 *
		 * @param string $id
		 * @param string $title
		 * @param array $inputs of Metabox_Input objects
		 */
		public function add_metabox( $id, $title, $inputs ) {
			add_meta_box( $id, $title, function () use ( $inputs ) {
				if ( $inputs ) {
					foreach ( $inputs as $input ) {

						if ( $input instanceof Metabox_Input ) {
							$input->render();
						}
					}
				}
			}, $this->post_type, $this->placement, 'high' );
		}

		/**
		 * Save meta
		 *
		 * @param int $post_id
		 * @param string $nonce_key
		 * @param string $meta_key
		 *
		 * @return int
		 */
		public static function save( $post_id, $nonce_key, $meta_key = '_think_meta' ) {
			$meta_data = ( ! array_key_exists( $meta_key, $_POST ) ) ? null : $_POST[ $meta_key ];

			if ( ! $meta_data ||
			     ! current_user_can( 'edit_pages' ) ||
			     ! array_key_exists( $nonce_key, $meta_data ) ||
			     ! wp_verify_nonce( $meta_data[ $nonce_key ], $nonce_key ) ||
			     defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
			) {
				return $post_id;
			}

			unset( $meta_data[ $nonce_key ] );

			return update_post_meta( $post_id, $meta_key, $meta_data );
		}

		/**
		 * Get metabox manager
		 *
		 * @param string $post_type
		 * @param string $place
		 *
		 * @return static
		 */
		public static function create( $post_type = 'post', $place = 'normal' ) {
			return new static( $post_type, $place );
		}

		/**
		 * Get meta info from unserialized meta
		 *
		 * @param string $key in get_post_meta() unserialized array
		 * @param array $meta After unserialize get_post_meta()
		 * @param string $default Default value
		 *
		 * @return string
		 */
		public static function get_value_from_unserialized_meta( $key, $meta, $default = '' ) {
			return ( ! array_key_exists( $key, $meta ) || ! $meta[ $key ] ) ? __( $default, 'wp-think-framework' ) : $meta[ $key ];
		}

		/**
		 * Convert string to array from unserialized meta
		 *
		 * @param $key
		 * @param $meta
		 *
		 * @return array
		 */
		public static function str_from_unserialized_meta_to_array( $key, $meta ) {
			if ( ! array_key_exists( $key, $meta ) || ! strpos( $meta[ $key ], ',' ) ) {
				return array();
			}

			return explode( ',', $meta[ $key ] );
		}
	}
}
