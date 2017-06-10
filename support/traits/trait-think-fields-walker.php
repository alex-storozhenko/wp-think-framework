<?php

if ( ! trait_exists( 'Think_Fields_Walker' ) ) {
	/**
	 * Parse structure and get all fields
	 *
	 * Trait Think_Fields_Walker
	 *
	 * @package wp-think-framework
	 */
	trait Think_Fields_Walker {
		/**
		 * Fields Walker
		 *
		 * @param array $fields
		 *
		 * @return array
		 */
		protected function walk_fields( array $fields ) {
			$walked_fields = array();

			foreach ( $fields as $field ) {
				$walked_fields = array_merge( $walked_fields, $this->walk_deeper_level( $field ) );
			}

			return $walked_fields;
		}

		/**
		 * Get child fields
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		protected function walk_deeper_level( array $field ) {
			if ( empty( $field['fields'] ) ) {
				return array( $field );
			} else {
				$fields = array();

				foreach ( $field['fields'] as $child_field ) {
					$fields = array_merge( $this->walk_deeper_level( $child_field ), $fields );
				}

				return $fields;
			}
		}
	}
}