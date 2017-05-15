<?php


if ( ! class_exists( 'Image' ) ) {
	/**
	 * Class Image
	 * Composite element. Render image field
	 *
	 * @package inc\bundle\metabox\inputs
	 */
	class Image extends Metabox_Input {

		/** Render HTML */
		public function render() {
			$src = $this->get_value();
			?>

            <p class="services_meta image">
				<?php if ( ! empty( $this->label ) ) { ?>
                    <label for="<?= $this->id ?>"><?= $this->label ?></label><br/>
				<?php } ?>

                <input type='text' name='_think_meta[<?= $this->id ?>]' id='<?= $this->id ?>' value='<?= $src ?>'/>
                <button class="button st_upload_button"><?= __( 'Select', TEXTDOMAIN ) ?></button>
                <button class="button st_delete_upload_button"><?= __( 'Remove', TEXTDOMAIN ) ?></button>

				<?php if ( ! empty( $src ) ) { ?>
                    <img class="image" alt="Uploaded image" src="<?= $src ?>"/>
				<?php } ?>
            </p>

			<?php
		}
	}
}
