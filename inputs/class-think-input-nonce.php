<?php

if ( ! class_exists( 'Think_Input_Nonce' ) ) {
	/**
	 * Nonce field.
	 *
	 * Class Think_Nonce_Input
	 */
	class Think_Input_Nonce extends Think_Abstract_Input {
		/**
		 * Redeclare initiator type.
		 *
		 * @var Think_Metaboxes
		 */
		protected $initiator;

		/**
		 * Use only for metaboxes.
		 *
		 * Think_Input_Nonce constructor
		 */
		public function __construct( Think_Metaboxes $initiator, $id, $label, array $options = [] ) {
			parent::__construct( $initiator, $id, $label, $options );
		}

		/** Render */
		public function render() {
			wp_nonce_field( $this->initiator->get_nonce_key(), $this->initiator->get_key() . '[' . $this->initiator->get_nonce_key() . ']', true );
		}
	}
}
