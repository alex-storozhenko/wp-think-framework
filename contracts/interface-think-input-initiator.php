<?php
if ( ! interface_exists( 'Think_Input_Initiator' ) ) {
	/**
	 * Contract for getter data
	 * Interface Think_Input_Initiator
	 *
	 * @package wp-think-framework
	 */
	interface Think_Input_Initiator {
		function get_data( $input_id );

		function get_key();
	}
}