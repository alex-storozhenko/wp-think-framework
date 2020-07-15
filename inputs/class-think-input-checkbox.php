<?php

if ( ! class_exists( 'Think_Input_Checkbox' ) ) {
	class Think_Input_Checkbox extends Think_Abstract_Input {
		/** Render */
		public function render() {
			?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab( get_class( $this->initiator ) ); ?> input-area input-area-check input-area-check-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
				<?php $check = ( $this->get_value() ) ? 'checked' : ''; ?>
                <label class="wp-think-framework input-label label-check label-check<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                    <input class="wp-think-framework input input-check input-check-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"
                           type="checkbox" <?= $check ?> name="<?= $this->initiator->get_key(); ?>[<?= $this->id ?>]"
                           value="<?= $this->get_value(); ?>"/>
                    <span class="wp-think-framework label-title label-title-check label-title-check-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"><?= $this->label; ?></span>
                </label>
            </div>
			<?php
		}

		/** Enqueue special assets */
		protected function enqueue_assets() {
			wp_enqueue_script( 'wp-think-framework-init-checkbox', THINK_FRAMEWORK_URI . '/inputs/assets/js/init.checkbox.js', [
				'jquery',
			], THINK_FRAMEWORK_VERSION, true );
		}
	}
}
