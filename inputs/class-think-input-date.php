<?php
if ( ! class_exists( 'Think_Input_Date' ) ) {
	/**
	 * Input datetime
	 *
	 * Class Think_Input_Date
	 *
	 * @package wp-think-framework
	 */
	class Think_Input_Date extends Think_Abstract_Input {
		/** Render */
		public function render() {
			?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab( get_class( $this->initiator ) ); ?> input-area input-area-date input-area-date-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                <label class="wp-think-framework input-label label-date label-date-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>">
                    <input class="wp-think-framework input-date input-date-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"
                           type="text" name="<?= $this->initiator->get_key(); ?>[<?= $this->id ?>]"
                           id="<?= $this->id ?>" value="<?= $this->get_value() ?>"/>
                    <span class="wp-think-framework label-title label-title-date label-title-date-<?= $this->id . ' ' . Think_Helper::str_snake_to_kebab( get_class( $this ) ); ?>"><?= $this->label; ?></span>
                </label>
            </div>
			<?php
		}

		/** Enqueue special assets */
		protected function enqueue_assets() {
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_register_style( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' );
			wp_enqueue_style( 'jquery-ui' );

			wp_enqueue_script( 'wp-think-framework-init-datepicker', THINK_FRAMEWORK_URI . '/inputs/assets/js/init.datepicker.js', array(
				'jquery',
				'jquery-ui-datepicker'
			), THINK_FRAMEWORK_VERSION, true );
		}
	}
}