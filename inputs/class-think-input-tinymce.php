<?php

if ( ! class_exists( 'Think_Input_TinyMCE' ) ) {
	/**
	 * Input include TinyMCE editor.
	 *
	 * Class Think_Input_TinyMCE
	 */
	class Think_Input_TinyMCE extends Think_Abstract_Input {
		/** Render */
		public function render() {
			?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab( get_class( $this->initiator ) ); ?> input-area input-area-tinymce input-area-tinymce-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                <label class="wp-think-framework input-label label-tinymce label-tinymce-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
					<?php
					wp_editor( $this->get_value(), $this->id . '_editor', [
						'textarea_name' => $this->initiator->get_key() . '[' . $this->id . ']',
						'tinymce'       => true,
						'teeny'         => false,
						'quicktags'     => true,
						'media_buttons' => true,
						'textarea_rows' => 20,
					] ); ?>
                    <span class="wp-think-framework label-title label-title-tinymce label-title-tinymce-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"><?= $this->label ?></span>
                </label>
            </div>
			<?php
		}
	}
}
