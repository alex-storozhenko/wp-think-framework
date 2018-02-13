<?php

if (!class_exists('Think_Abstract_Handler')) {
    /**
     * Abstract handler
     * for forms,ajax and etc.
     *
     * Class Think_Abstract_Handler
     */
    abstract class Think_Abstract_Handler
    {
        use Think_Auto_Ajax, Think_Can_Verify_Nonce;

        /** Think_Abstract_Handler constructor */
        abstract public function __construct();

        /** @return mixed */
        abstract public function handler();

        /**
         * Send response.
         *
         * @param array $content
         * @param int   $status_code
         */
        protected function response(array $content, $status_code = 200)
        {
            /* @call Think_Json_Response::send from __callStatic */
            Think_Json_Response::send_response($content, $status_code);
        }

        /**
         * Send mail wrapper.
         *
         * @param $to
         * @param $subject
         * @param $message
         * @param $headers
         *
         * @return bool
         */
        protected function send_mail($to, $subject, $message, $headers)
        {
            return wp_mail($to, $subject, $message, $headers);
        }
    }
}
