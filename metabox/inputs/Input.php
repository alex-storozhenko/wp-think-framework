<?php


if ( ! class_exists( 'Input' ) ) {
	/**
	 * Class Input
	 * Composite element. Render Input field
	 *
	 * @package inc\bundle\metabox\inputs
	 */
	class Input extends Metabox_Input {

		/** Render HTML */
		public function render() { ?>

            <p class="services_meta input">
				<?php if ( ! empty( $this->label ) ) { ?>
                    <label for="<?= $this->id ?>"><?= $this->label ?></label><br/>
				<?php } ?>

                <input type="text" name="_think_meta[<?= $this->id ?>]" id="<?= $this->id ?>"
                       value="<?= $this->get_value() ?>"/>
            </p>

			<?php
		}
	}
}
