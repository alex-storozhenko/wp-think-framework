<?php

if ( ! class_exists( 'Think_Abstract_Input' ) ) {
	/**
	 * Common logic of inputs
	 *
	 * class Think_Input
	 *
	 * @package wp-think-framework
	 */
	abstract class Think_Abstract_Input implements Think_Input {
		/**
		 * Class input caller
		 *
		 * @var Think_Input_Initiator $initiator
		 */
		protected $initiator;

		/**
		 * Uniq Id for input
		 *
		 * @var string $id
		 */
		protected $id;

		/**
		 * Input label
		 *
		 * @var string $label
		 */
		protected $label;

		/**
		 * Array of options for render select type inputs
		 *
		 * @var array
		 */
		protected $options;

		/**
		 * Think_Inputs constructor
		 *
		 * @param Think_Input_Initiator $initiator
		 * @param $id
		 * @param $label
		 * @param array $options
		 */
		public function __construct( Think_Input_Initiator $initiator, $id, $label, array $options ) {
			$this->initiator = $initiator;
			$this->id        = $id;
			$this->label     = $label;
			$this->options   = $options;

			/**
			 * Since version 3.3
			 * Wp_enqueue_script() can be called at the time the page is generated.
			 * In this case, the called script will be connected in the basement,
			 * at the moment when wp_footer events are triggered.
			 *
			 * It is necessary for dynamic connection of scripts and styles
			 * during the generation of input
			 */
			$this->enqueue_assets();
		}

		/**
		 * Get Id
		 *
		 * @return string
		 */
		public function get_id() {
			return $this->id;
		}

		/**
		 * Get label
		 *
		 * @return string
		 */
		public function get_label() {
			return $this->label;
		}

		/**
		 * Get options
		 *
		 * @return array
		 */
		public function get_options() {
			return $this->options;
		}

		/**
		 * Rewrite in use classes
		 *
		 * @return mixed
		 */
		abstract public function render();

		/**
		 * Getting value
		 *
		 * @return string
		 */
		public function get_value() {
			return $this->initiator->get_data( $this->id );
		}

		/** Enqueue assets */
		protected function enqueue_assets() {
			wp_enqueue_style( 'wp-think-framework-inputs-style', THINK_FRAMEWORK_URI . '/inputs/assets/css/style.css', array(), THINK_FRAMEWORK_VERSION );
		}
	}
}