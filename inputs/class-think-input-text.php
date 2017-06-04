<?php
if ( ! class_exists( 'Think_Input_Text' ) ) {
	/**
	 * Input type text
	 *
	 * Class Think_Input_Text
	 *
	 * @package wp-think-framework
	 */
	class Think_Input_Text extends Think_Abstract_Input {
		/** Render */
		public function render() {
			?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab( get_class( $this->initiator ) ); ?> input-area input-area-text input-area-text-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                <label class="wp-think-framework input-label label-text label-text-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                    <input class="wp-think-framework input input-text input-text-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"
                           type="text" name="<?= $this->initiator->get_key(); ?>[<?= $this->id; ?>]"
                           value="<?= $this->get_value() ?>"/>
                    <span class="wp-think-framework label-title label-title-text label-title-text-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"><?= $this->label; ?></span>
                </label>
            </div>
			<?php
		}
	}
}