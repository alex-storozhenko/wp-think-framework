<?php

if ( ! class_exists( 'Think_Call_Unexpected_Method_Exception' ) ) {
	/**
	 * Exception
	 *
	 * Class Think_Call_Unexpected_Method_Exception
	 *
	 * @package wp-think-framework
	 */
	class Think_Call_Unexpected_Method_Exception extends Exception {

		/**
		 * Think_Call_Unexpected_Method_Exception constructor
		 *
		 * @param string $message
		 * @param int $code
		 * @param Throwable|null $previous
		 */
		public function __construct( $message = "", $code = 500, Throwable $previous = null ) {
			parent::__construct( $message, $code, $previous );
		}
	}
}