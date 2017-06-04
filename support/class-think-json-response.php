<?php

if ( ! class_exists( 'Think_Json_Response' ) ) {
	/**
	 * Class Json_Response
	 *
	 * @method static send_response( array $body, $status_code );
	 *
	 * @package wp-think-framework
	 */
	class Think_Json_Response {

		/** @var array $response_body */
		protected $response_body = [];

		/** @var int $status_code */
		protected $status_code;

		/**
		 * Json_Response constructor
		 *
		 * @param array $body
		 * @param $status_code
		 */
		public function __construct( array $body, $status_code ) {
			$this->response_body = $body;
			$this->status_code   = $status_code;
		}

		/**
		 * Static caller for send method
		 *
		 * @param $name
		 * @param $arguments [@param array $body, @param $status_code]
		 *
		 * @throws Exception
		 */
		public static function __callStatic( $name, $arguments ) {
			if ( mb_strpos( $name, 'send_response' ) !== true && count( $arguments ) !== 2 ) {
				throw new Think_Call_Unexpected_Method_Exception( 'Call unexpected method', 500 );
			}

			return ( new static( $arguments[0], $arguments[1] ) )->send();
		}

		/** Send JSON Response to frontend */
		public function send() {
			wp_send_json( $this->response_body, $this->status_code );
		}

		/** @return array */
		public function get_response_body() {
			return $this->response_body;
		}

		/** @param array $response_body */
		public function set_response_body( $response_body ) {
			$this->response_body = $response_body;
		}

		/** @return int */
		public function get_status_code() {
			return $this->status_code;
		}

		/** @param int $status_code */
		public function set_status_code( $status_code ) {
			$this->status_code = $status_code;
		}
	}
}