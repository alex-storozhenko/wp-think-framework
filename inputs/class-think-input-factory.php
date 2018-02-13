<?php

if (!class_exists('Think_Input_Factory')) {
    /**
     * Input maker.
     *
     * Class Think_Input_Factory
     */
    class Think_Input_Factory
    {
        /**
         * Input factory.
         *
         * @param Think_Input_Initiator $initiator
         * @param array                 $input_structure
         *
         * @throws Think_Call_Unexpected_Method_Exception
         *
         * @return mixed
         */
        public static function make(Think_Input_Initiator $initiator, array $input_structure)
        {
            $type = (empty($input_structure['type'])) ? 'text' : $input_structure['type'];

            if ($type === 'col') {
                $width = (empty($input_structure['width'])) ? 1 : $input_structure['width'];
                $structure = (empty($input_structure['fields'])) ? [] : $input_structure['fields'];

                return new Think_Input_Col($initiator, $structure, $width);
            } elseif ($type === 'row') {
                $structure = (empty($input_structure['fields'])) ? [] : $input_structure['fields'];

                return new Think_Input_Row($initiator, $structure);
            }

            $id = $input_structure['id'];
            $label = (!empty($input_structure['label'])) ? $input_structure['label'] : '';
            $options = (!empty($input_structure['options']) ? $input_structure['options'] : []);

            $name_of_input_class = 'Think_Input_'.ucfirst($type);

            if (!class_exists($name_of_input_class) ||
                 !in_array('Think_Input', class_implements($name_of_input_class))
            ) {
                throw new Think_Call_Unexpected_Method_Exception('Method not exists. You should add needed input class');
            }

            return new $name_of_input_class($initiator, $id, $label, $options);
        }
    }
}
