<?php

if (!interface_exists('Think_Input_Initiator')) {
    /**
     * Contract for getter data
     * Interface Think_Input_Initiator.
     */
    interface Think_Input_Initiator
    {
        /**
         * Get data from storage by input_id.
         *
         * @param $input_id
         *
         * @return mixed
         */
        public function get_data($input_id);

        /**
         * Unique key
         * for processing input.
         *
         * @return mixed
         */
        public function get_key();
    }
}
