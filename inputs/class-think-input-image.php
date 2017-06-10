<?php

if ( ! class_exists( 'Think_Input_Image' ) ) {
	/**
	 * Input include call media lib
	 *
	 * Class Think_Input_Image
	 *
	 * @package wp-think-framework
	 */
	class Think_Input_Image extends Think_Abstract_Input {
		/** Render */
		public function render() {
			$value = $this->get_value();
			?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab( get_class( $this->initiator ) ); ?> input-area input-area-image input-area-image-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                <label class="wp-think-framework input-label label-image label-image-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                    <input class="wp-think-framework input input-text input-text-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"
                           type="text" name="<?= $this->initiator->get_key(); ?>[<?= $this->id ?>]"
                           id="<?= $this->id ?>" value="<?= $value ?>"/>
                    <span class="wp-think-framework label-title label-title-image label-title-image-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"><?= $this->label; ?></span>
                </label>
                <div class="wp-think-framework button-group">
                    <button class="wp-think-framework button call-media"><?= __( 'Select', 'wp-think-framework' ) ?></button>
                    <button class="wp-think-framework button remove-image"><?= __( 'Clear', 'wp-think-framework' ) ?></button>
                    <button class="wp-think-framework button preview-image" <?= ( ! $value ) ? 'disabled' : ''; ?>><?= __( 'Preview', 'wp-think-framework' ) ?></button>
                </div>
                <div id="popup-<?= $this->id; ?>" class="wp-think-framework popup-overlay hidden">
                    <div class="wp-think-framework popup-preview-image">
                        <span class="wp-think-framework popup-preview-image-title">Image preview</span>
                        <img class="wp-think-framework image" src="<?= $value ?: 'javascript:;' ?>"/>
                        <a class="close" href="javascript:;">&times;</a>
                    </div>
                </div>
            </div>
			<?php
		}

		/** Enqueue special assets */
		protected function enqueue_assets() {
			wp_enqueue_media();
			wp_enqueue_script( 'wp-think-framework-init-uploader', THINK_FRAMEWORK_URI . '/inputs/assets/js/init.uploader.js', array( 'jquery' ), THINK_FRAMEWORK_VERSION, true );
		}
	}
}