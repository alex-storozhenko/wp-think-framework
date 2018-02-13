<?php

if (!class_exists('Think_Exception_Bad_Args_For_Called_Func')) {
    /**
     * Exception.
     *
     * Class Think_Exception_Bad_Args_For_Called_Func
     */
    class Think_Exception_Bad_Args_For_Called_Func extends Exception
    {
        /**
         * Exception_Bad_Args_For_Called_Func constructor.
         *
         * @param string         $message
         * @param int            $code
         * @param Throwable|null $previous
         */
        public function __construct($message = '', $code = 500, Throwable $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
    }
}
