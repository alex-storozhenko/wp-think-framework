<?php


if ( ! class_exists( 'Checkbox' ) ) {
	/**
	 * Class Checkbox
     *
	 * Composite element. Render Input field
	 */
	class Checkbox extends Metabox_Input {

		/** @var  array $options */
		public $options;

		/**
		 * Select constructor.
		 *
		 * @param $id
		 * @param string $label
		 */
		public function __construct( $id, $label ) {
			parent::__construct( $id, $label );
		}

		/** Render HTML */
		public function render() { ?>

            <p class="services_meta">
				<?php $check = ( $this->get_value() ) ? 'checked' : ''; ?>
                <input type="checkbox" <?= $check ?> name="_think_meta[<?= $this->id ?>]" id="<?= $this->id ?>"
                       value="<?= $this->get_value() ?>  "/>
				<?php if ( ! empty( $this->label ) ) { ?>
                    <label for="<?= $this->id ?>"><?= $this->label ?></label><br/>
				<?php } ?>
            </p>

			<?php
		}
	}
}