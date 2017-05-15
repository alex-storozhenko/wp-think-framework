<?php


if ( ! class_exists( 'Textarea' ) ) {
	/**
	 * Class Textarea
	 * Composite element. Render textarea
	 *
	 * @package inc\bundle\metabox\inputs
	 */
	class Textarea extends Metabox_Input {

		/**
		 * Render HTML
		 */
		public function render() { ?>

            <p class="services_meta textarea">
				<?php if ( ! empty( $this->label ) ) { ?>
                    <label for="<?= $this->id ?>"><?= $this->label ?></label><br/>
				<?php } ?>

                <textarea name="_think_meta[<?= $this->id ?>]"
                          id="<?= $this->id ?>"><?= $this->get_value() ?></textarea>
            </p>

			<?php
		}
	}
}
