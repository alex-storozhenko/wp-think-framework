<?php

if ( ! class_exists( 'Think_Customize_TinyMCE_Control' ) && class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Render WP Editor input in customizer.
	 *
	 * Class Think_Customize_TinyMCE_Control
	 */
	class Think_Customize_TinyMCE_Control extends WP_Customize_Control {
		/** {@inheritdoc}*/
		public $type = 'textarea';

		/** {@inheritdoc} */
		public function __construct( WP_Customize_Manager $manager, $id, array $args = array() ) {
			add_action( 'customize_controls_enqueue_scripts', function () {
				$this->enqueue_assets();
			} );

			parent::__construct( $manager, $id, $args );
		}

		/** {@inheritdoc} */
		public function render_content() {
			?>
            <div class="wp-think-framework <?php echo Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?> customizer-input-area customizer-input-area-tinyMCE customizer-input-area-tinyMCE-<?php echo $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                <div class="wp-think-framework customizer-input-description customizer-input-description-tinyMCE customizer-input-description-tinyMCE-<?php echo $this->id; ?>"><?php echo esc_attr( $this->description ); ?></div>
                <label class="wp-think-framework customizer-label-input customizer-label-input-tinyMCE customizer-label-input-tinyMCE-<?php echo $this->id; ?>">
					<?php
					add_filter( 'the_editor', function ( $output ) {
						return preg_replace( '/<textarea/', '<textarea ' . $this->get_link(), $output, 1 );
					} );

					wp_editor( $this->value(), $this->id, array(
						'textarea_name'    => $this->id,
						'media_buttons'    => false,
						'drag_drop_upload' => false,
						'teeny'            => true,
						'quicktags'        => true,
						'textarea_rows'    => 5,
					) ); ?>
                    <span class="wp-think-framework customizer-label-title customizer-label-title-tinyMCE customizer-label-title-tinyMCE-<?php echo Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"><?php echo esc_html( $this->label ); ?></span>
                </label>
            </div>
			<?php
			do_action( 'admin_print_footer_scripts' );
		}

		/** Enqueue special assets */
		protected function enqueue_assets() {
			wp_enqueue_script( 'wp-editor-customizer', get_stylesheet_directory_uri() . '/inc/customizer/assets/js/customizer.tiny-mce.js', array( 'jquery' ), VERSION, true );
		}
	}
}
