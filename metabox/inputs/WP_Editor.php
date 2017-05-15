<?php


if ( ! class_exists( 'WP_Editor' ) ) {
	/**
	 * Class WP_Editor
	 * Composite element. Render standard Worpress editor
	 *
	 * @package inc\bundle\metabox\inputs
	 */
	class WP_Editor extends Metabox_Input {

		/** Render HTML*/
		public function render() { ?>

            <p class="services_meta wp_editor">
				<?php if ( ! empty( $this->label ) ) { ?>
                    <label for="<?= $this->id ?>"><?= $this->label ?></label><br/>
				<?php } ?>

				<?php
				wp_editor( $this->get_value(), $this->id . '_editor', array(
					'textarea_name' => '_think_meta[' . $this->id . ']',
					'tinymce'       => true,
					'teeny'         => false,
					'quicktags'     => true,
					'media_buttons' => true,
					'textarea_rows' => 20,
				) );
				?>
            </p>

			<?php
		}
	}
}
