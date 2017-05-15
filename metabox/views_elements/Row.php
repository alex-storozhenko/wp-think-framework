<?php


if ( ! class_exists( 'Row' ) ) {
	/**
	 * Class Row
	 * Composite container, place elements in special div
	 *
	 * @package think\bundle\metabox\viewviews_elements_els
	 */
	class Row extends Metabox_Input {

		/** @var array */
		public $inputs;

		/**
		 * Row constructor.
		 *
		 * @param array $inputs
		 */
		public function __construct( $inputs = array() ) {
			parent::__construct( $this->id, $this->label );

			$this->inputs = $inputs;
		}

		/**
		 * @param Metabox_Input $input
		 */
		public function remove_input( Metabox_Input $input ) {
			$this->inputs = array_diff( $this->inputs, array( $input ), function ( $a, $b ) {
				return ( $a === $b ) ? 0 : 1;
			} );
		}

		/**
		 * @param Metabox_Input $input
		 */
		public function add_input( Metabox_Input $input ) {
			if ( in_array( $input, $this->inputs, true ) ) {
				return;
			}

			$this->inputs[] = $input;
		}

		/** Render HTML */
		public function render() { ?>

            <div class="services_meta row" id="<?= $this->id ?>">
				<?php foreach ( $this->inputs as $input ) {
					if ( $input instanceof Metabox_Input ) {
						$input->render();
					}
				} ?>
            </div>

			<?php
		}
	}
}
