<?php


if ( ! class_exists( 'Col' ) ) {
	/**
	 * Class Col
	 * Composite container, place elements in special div
	 * You can set column width: 6 = 50%, 4 = 33%, 3 = 25%, 2 = 16.66%
	 * if 1 or empty, width = 100%
	 *
	 * @package think\bundle\metabox\views_elements
	 */
	class Col extends Metabox_Input {

		public $width;
		public $inputs;

		public function __construct( $width = 1, $inputs = array() ) {
			parent::__construct( $this->id, $this->label );

			$this->width  = $width;
			$this->inputs = $inputs;
		}

		public function remove_input( Metabox_Input $input ) {
			$this->inputs = array_diff( $this->inputs, array( $input ), function ( $a, $b ) {
				return ( $a === $b ) ? 0 : 1;
			} );
		}

		public function add_input( Metabox_Input $input ) {
			if ( in_array( $input, $this->inputs, true ) ) {
				return;
			}

			$this->inputs[] = $input;
		}

		public function render() { ?>

            <div class="col col-<?= 12 / $this->width ?>" id="<?= $this->id ?>">
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
