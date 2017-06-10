<?php

if ( ! class_exists( 'Think_Input_Col' ) ) {
	/**
	 * Composite container, place elements in special div
	 * You can set column width: 6 = 50%, 4 = 33%, 3 = 25%, 2 = 16.66%
	 * if 1 or empty, width = 100%
	 *
	 * Class Think_Input_Col
	 *
	 * @package wp-think-framework
	 */
	class Think_Input_Col extends Think_Abstract_Input {
		/**
		 * Redeclare initiator type
		 *
		 * @var Think_Metaboxes $initiator
		 */
		protected $initiator;

		/**
		 * Width of container
		 *
		 * @var int
		 */
		protected $width;

		/**
		 * Inputs collection
		 *
		 * @var array
		 */
		protected $structure;

		/**
		 * Think_Input_Col constructor.
		 *
		 * @param Think_Metaboxes $initiator
		 * @param array $structure
		 * @param int $width
		 */
		public function __construct( Think_Metaboxes $initiator, array $structure, $width = 1 ) {
			$this->structure = $structure;
			$this->width     = $width;

			parent::__construct( $initiator, 'wptf-col' . uniqid( '_' ) . '_' . Think_Helper::str_snake_to_kebab( get_class( $this->initiator ) ), '', array() );
		}

		/** Render */
		public function render() {
			?>
            <div class="wp-think-framework <?= Think_Helper::str_snake_to_kebab( get_class( $this->initiator ) ); ?> col col-<?= 12 / $this->width ?>"
                 id="<?= $this->id ?>">
				<?php
				foreach ( $this->structure as $input_structure ) {
					$input = Think_Input_Factory::make( $this->initiator, $input_structure );

					$input->render();
				}
				?>
            </div>
			<?php
		}
	}
}