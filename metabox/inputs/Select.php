<?php


if ( ! class_exists( 'Select' ) ) {
	/**
	 * Class Select
	 * Composite element. Render select box
	 *
	 * @package inc\bundle\metabox\inputs
	 */
	class Select extends Metabox_Input {

		/** @var array $options */
		public $options;

		/**
		 * Select constructor.
		 *
		 * @param $id
		 * @param string $label
		 * @param $options
		 */
		public function __construct( $id, $label, $options ) {
			parent::__construct( $id, $label );
			$this->options = $options;
		}

		/** Render HTML */
		public function render() { ?>

            <p class="services_meta select">

				<?php if ( ! empty( $this->label ) ) { ?>
                    <label for="<?= $this->id ?>"><?= $this->label ?></label><br/>
				<?php } ?>

                <select name="_think_meta[<?= $this->id ?>]" id="<?= $this->id ?>">
					<?php foreach ( $this->options as $id => $label ) {
						$sel = ( $id == $this->get_value() ) ? 'selected' : '' ?>

                        <option value="<?= $id ?>" <?= $sel ?>><?= $label ?></option>
					<?php } ?>
                </select>
            </p>

			<?php
		}
	}
}
