<?php

if ( ! class_exists( 'Think_Abstract_Handler' ) ) {
	/** Class Abstract_Handler */
	abstract class Think_Abstract_Handler {
		use Auto_Ajax;

		/** Handler Constructor **/
		abstract public function __construct();

		/** Main logic of handler **/
		abstract public function handler();

		/**
		 * Send response
		 *
		 * @param array $content
		 * @param int $status_code
		 */
		protected function response( array $content, $status_code = 200 ) {
			//@call Think_Json_Response::send from __callStatic
			Think_Json_Response::send_response( $content, $status_code );
		}

		/**
		 * Check CSRF protection
		 *
		 * @param $nonce
		 * @param $action
		 *
		 * @return false|int
		 */
		protected function check_nonce( $nonce, $action ) {
			return wp_verify_nonce( $nonce, $action );
		}

		/**
		 * Send mail wrapper
		 *
		 * @param $to
		 * @param $subject
		 * @param $message
		 * @param $headers
		 *
		 * @return bool
		 */
		protected function send_mail( $to, $subject, $message, $headers ) {
			return wp_mail( $to, $subject, $message, $headers );
		}
	}
}