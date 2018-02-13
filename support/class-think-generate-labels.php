<?php

if (!class_exists('Think_Generate_Labels')) {
    /**
     * Labels generator
     * for registration cpt or taxonomy.
     *
     * Class Think_Generate_Labels
     */
    class Think_Generate_Labels
    {
        /**
         * Generator all labels for taxonomy_register().
         *
         * @param $name_singular
         * @param $name_plural
         *
         * @return array
         */
        public static function taxonomy($name_singular, $name_plural)
        {

            /**
             * change all text in Capitalize style example:
             * 'products category' -> 'Products Category'.
             **/
            $ucwords_singular = ucwords($name_singular);
            $ucwords_plural = ucwords($name_plural);

            $labels = [
                'name'                       => _x($ucwords_plural, 'Taxonomy General Name', 'wp-think-framework'),
                'singular_name'              => _x($ucwords_singular, 'Taxonomy Singular Name', 'wp-think-framework'),
                'menu_name'                  => __($ucwords_plural, 'wp-think-framework'),
                'all_items'                  => __('All '.$ucwords_plural, 'wp-think-framework'),
                'parent_item'                => __('Parent '.$ucwords_singular, 'wp-think-framework'),
                'parent_item_colon'          => __('Parent '.$ucwords_singular.':', 'wp-think-framework'),
                'add_new_item'               => __('Add New '.$ucwords_singular, 'wp-think-framework'),
                'edit_item'                  => __('Edit '.$ucwords_singular, 'wp-think-framework'),
                'update_item'                => __('Update '.$ucwords_singular, 'wp-think-framework'),
                'view_item'                  => __('View '.$ucwords_singular, 'wp-think-framework'),
                'separate_items_with_commas' => __('Separate '.$ucwords_plural.' with commas', 'wp-think-framework'),
                'add_or_remove_items'        => __('Add or remove '.$ucwords_plural, 'wp-think-framework'),
                'choose_from_most_used'      => __('Choose from the most used '.$ucwords_singular, 'wp-think-framework'),
                'popular_items'              => __('Popular '.$ucwords_plural, 'wp-think-framework'),
                'search_items'               => __('Search '.$ucwords_plural, 'wp-think-framework'),
                'not_found'                  => __('Not Found '.$ucwords_plural, 'wp-think-framework'),
                'no_terms'                   => __('No '.$ucwords_plural, 'wp-think-framework'),
                'items_list'                 => __($ucwords_plural.' list', 'wp-think-framework'),
                'items_list_navigation'      => __($ucwords_plural.' list navigation', 'wp-think-framework'),
            ];

            return $labels;
        }

        /**
         * Generator all labels for custom_post_type_register().
         *
         * @param $name_singular
         * @param $name_plural
         *
         * @return array
         */
        public static function cpt($name_singular, $name_plural)
        {
            /**
             * change all text in Capitalize style example:
             * 'products' -> 'Products'.
             **/
            $ucwords_singular = ucwords($name_singular);
            $ucwords_plural = ucwords($name_plural);

            $labels = [
                'name'                  => _x($ucwords_plural, 'Post Type General Name', 'wp-think-framework'),
                'singular_name'         => _x($ucwords_singular, 'Post Type Singular Name', 'wp-think-framework'),
                'menu_name'             => __($ucwords_plural, 'wp-think-framework'),
                'name_admin_bar'        => __($ucwords_singular, 'wp-think-framework'),
                'archives'              => __($ucwords_singular.'Archives', 'wp-think-framework'),
                'parent_item_colon'     => __('Parent '.$ucwords_singular.':', 'wp-think-framework'),
                'all_items'             => __('All '.$ucwords_plural, 'wp-think-framework'),
                'add_new_item'          => __('Add New '.$ucwords_singular, 'wp-think-framework'),
                'add_new'               => __('Add '.$ucwords_singular, 'wp-think-framework'),
                'new_item'              => __('New '.$ucwords_singular, 'wp-think-framework'),
                'edit_item'             => __('Edit '.$ucwords_singular, 'wp-think-framework'),
                'update_item'           => __('Update '.$ucwords_singular, 'wp-think-framework'),
                'view_item'             => __('View '.$ucwords_singular, 'wp-think-framework'),
                'search_items'          => __('Search '.$ucwords_singular, 'wp-think-framework'),
                'not_found'             => __('Not found '.$ucwords_singular, 'wp-think-framework'),
                'not_found_in_trash'    => __('Not found '.$ucwords_singular.'in Trash', 'wp-think-framework'),
                'featured_image'        => __('Featured Image', 'wp-think-framework'),
                'set_featured_image'    => __('Set featured image', 'wp-think-framework'),
                'remove_featured_image' => __('Remove featured image', 'wp-think-framework'),
                'use_featured_image'    => __('Use as featured image', 'wp-think-framework'),
                'insert_into_item'      => __('Insert into '.$name_singular, 'wp-think-framework'),
                'uploaded_to_this_item' => __('Uploaded to this '.$name_singular, 'wp-think-framework'),
                'items_list'            => __($ucwords_plural.' list', 'wp-think-framework'),
                'items_list_navigation' => __($ucwords_plural.' list navigation', 'wp-think-framework'),
                'filter_items_list'     => __('Filter '.$ucwords_plural.' list', 'wp-think-framework'),
            ];

            return $labels;
        }
    }
}
