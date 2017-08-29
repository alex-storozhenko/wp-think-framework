<?php
if ( ! interface_exists( 'Think_Input_Initiator' ) ) {
	/**
	 * Contract for getter data
	 * Interface Think_Input_Initiator
	 *
	 * @package wp-think-framework
	 */
	interface Think_Input_Initiator {
        /**
         * Get data from storage by input_id
         *
         * @param $input_id
         *
         * @return mixed
         */
	    function get_data( $input_id );

        /**
         * Unique key
         * for processing input
         *
         * @return mixed
         */
		function get_key();
	}
}