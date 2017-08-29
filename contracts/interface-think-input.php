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
        /**
         * Get unique id of input
         *
         * @return mixed
         */
	    public function get_id();

        /**
         * Get label of input
         *
         * @return mixed
         */
		public function get_label();

        /**
         * Get options for input
         *
         * @return mixed
         */
		public function get_options();

        /**
         * Get value of input
         *
         * @return mixed
         */
		public function get_value();

        /**
         * Render html
         *
         * @return string
         */
		public function render();
	}
}