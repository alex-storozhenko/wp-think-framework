<?php

if ( ! interface_exists( 'Think_Input' ) ) {
	/**
	 * Contract for input render
	 *
	 * Interface Think_Input
	 *
	 * @package wp-think-framework
	 */
	interface Think_Input {
		public function get_id();

		public function get_label();

		public function get_options();

		public function get_value();

		public function render();
	}
}