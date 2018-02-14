<?php

if (!trait_exists('Think_Fields_Walker')) {
    /**
     * Parse structure and get all fields.
     *
     * Trait Think_Fields_Walker
     */
    trait Think_Fields_Walker
    {
        /**
         * Fields structure.
         *
         * @var array
         */
        protected $structure;

        /**
         * Fields Walker.
         *
         * @param array $fields
         *
         * @return array
         */
        protected function walk_fields(array $fields)
        {
            $walked_fields = [];

            foreach ($fields as $field) {
                $walked_fields = array_merge($walked_fields, $this->walk_deeper_level($field));
            }

            return $walked_fields;
        }

        /**
         * Get child fields.
         *
         * @param array $field
         *
         * @return array
         */
        protected function walk_deeper_level(array $field)
        {
            if (empty($field['fields'])) {
                return [$field];
            } else {
                $fields = [];

                foreach ($field['fields'] as $child_field) {
                    $fields = array_merge($this->walk_deeper_level($child_field), $fields);
                }

                return $fields;
            }
        }

        /**
         * Get fields.
         *
         * @param null $key
         *
         * @return bool|array
         */
        public function get_fields($key = null)
        {
            $fields = [];

            if ($key) {
                $fields = $this->walk_fields($this->structure[$key]['fields']);
            } else {
                foreach ($this->structure as $section) {
                    $fields = array_merge($fields, $this->walk_fields($section['fields']));
                }
            }

            return $fields;
        }
    }
}
