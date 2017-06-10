<?php
if ( ! class_exists( 'Think_Input_Color' ) ) {
	class Think_Input_Color extends Think_Abstract_Input {
		/** Render */
		public function render() {
			?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab( get_class( $this->initiator ) ); ?> input-area input-area-color input-area-color-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                <label class="wp-think-framework input-label label-color label-color<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                    <input class="wp-think-framework input input-color input-color-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"
                           type="text" name="<?= $this->initiator->get_key(); ?>[<?= $this->id; ?>]"
                           value="<?= $this->get_value() ?>"/>
                    <span class="wp-think-framework label-title label-title-color label-title-color-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"><?= $this->label; ?></span>
                </label>
            </div>
			<?php
		}

		/** Enqueue special assets */
		protected function enqueue_assets() {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_script( 'wp-think-framework-init-colorpicker', THINK_FRAMEWORK_URI . '/inputs/assets/js/init.colorpicker.js', array(
				'jquery',
				'wp-color-picker'
			), THINK_FRAMEWORK_VERSION, true );
		}
	}
}