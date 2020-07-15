<?php

if ( ! class_exists( 'Think_Customize_Date_Control' ) && class_exists( 'WP_Customize_Color_Control' ) ) {
	/**
	 * Render Datetime input in customizer.
	 *
	 * Class Think_Customize_Datetime_Control
	 */
	class Think_Customize_Date_Control extends WP_Customize_Color_Control {
		/** {@inheritdoc} */
		public function enqueue() {
			wp_enqueue_style( 'jquery-ui-datepicker' );
		}

		/** {@inheritdoc} */
		public function render_content() {
			?>
            <div class="wp-think-framework <?php echo str_snake_to_kebab( get_class( $this ) ); ?> customizer-input-area customizer-input-area-date customizer-input-area-date-<?php echo $this->id . ' ' . str_snake_to_kebab( get_class( $this ) ); ?>">
                <div class="wp-think-framework customizer-input-description customizer-input-description-date customizer-input-description-date-<?php echo $this->id; ?>"><?php echo esc_attr( $this->description ); ?></div>
                <label class="wp-think-framework customizer-label-input customizer-label-input-date customizer-label-input-date-<?php echo $this->id; ?>">
                    <input type="date"
                           class="wp-think-framework customizer-input customizer-input-date customizer-input-date-<?php echo $this->id; ?>"
                           id="<?php echo $this->id; ?>" name="<?php echo $this->id; ?>"
                           value="<?php echo $this->value(); ?>"/>
                    <span class="wp-think-framework customizer-label-title customizer-label-title-date customizer-label-title-date-<?= str_snake_to_kebab( get_class( $this ) ); ?>"><?php echo esc_html( $this->label ); ?></span>
                </label>
            </div>
			<?php
		}
	}
}
