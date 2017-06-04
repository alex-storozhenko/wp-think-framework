<?php

if ( ! class_exists( 'Think_Input_Select' ) ) {
	/**
	 * Input type select
	 *
	 * Class Think_Input_Select
	 *
	 * @package wp-think-framework
	 */
	class Think_Input_Select extends Think_Abstract_Input {

		/**
		 * Think_Input_Select constructor
		 *
		 * @param Think_Input_Initiator $initiator
		 * @param $id
		 * @param $label
		 * @param array $options
		 */
		public function __construct( Think_Input_Initiator $initiator, $id, $label, array $options ) {
			parent::__construct( $initiator, $id, $label, $options );
		}

		/** Render */
		public function render() {
			?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab( get_class( $this->initiator ) ); ?> input-area input-area-select input-area-select-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                <label class="wp-think-framework input-label label-select label-select-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                    <select class="wp-think-framework input input-select input-select-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"
                            name="<?= $this->initiator->get_key(); ?>[<?= $this->id ?>]">
						<?php foreach ( $this->options as $value => $title ) {
							$sel = ( $value == $this->get_value() ) ? 'selected' : '' ?>
                            <option value="<?= $value ?>" <?= $sel ?>><?= $title ?></option>
						<?php } ?>
                    </select>
                    <span class="wp-think-framework label-title label-title-select label-title-select-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"><?= $this->label; ?></span>
                </label>
            </div>
			<?php
		}
	}
}