<?php

if ( ! class_exists( 'Think_Input_Sanitizer' ) ) {
	/**
	 * Sanitize value
	 *
	 * Class Think_Input_Sanitizer
	 *
	 *
	 * @package wp-think-framework
	 */
	class Think_Input_Sanitizer {
		/**
		 * Sanitize for text fields
		 *
		 * @param string $value
		 *
		 * @return string
		 */
		public function text_input( $value ) {
			return sanitize_text_field( $value );
		}

		/**
		 * Sanitize for hex color(#8470ff) fields
		 *
		 * @param $value
		 *
		 * @return string
		 */
		public function color_input( $value ) {
			return (string) sanitize_hex_color( $value );
		}

		/**
		 * Sanitize for url fields
		 *
		 * @param $value
		 *
		 * @return string
		 */
		public function url_input( $value ) {
			return esc_url( $value );
		}

		/**
		 * Sanitize for email fields
		 *
		 * @param $value
		 *
		 * @return string
		 */
		public function email_input( $value ) {
			return sanitize_email( $value );
		}

		/**
		 * Sanitize textarea
		 *
		 * @param $value
		 *
		 * @return string
		 */
		public function textarea_input( $value ) {
			return sanitize_textarea_field( $value );
		}

		/**
		 * Return value without sanitize
		 *
		 * @param $value
		 *
		 * @return mixed
		 */
		public function none_sanitize_input( $value ) {
			return $value;
		}

		/**
		 * Sanitize input by pattern(regex)
		 *
		 * @param $pattern
		 * @param $value
		 *
		 * @return mixed
		 */
		public function by_pattern_input( $pattern, $value ) {
			return preg_filter( $pattern, '', $value );
		}

		/**
		 * Sanitize fields
		 *
		 * @param array $values
		 * @param array $registered_fields All registered fields
		 *
		 * @return array
		 *
		 * @throws Think_Call_Unexpected_Method_Exception|Think_Exception_Bad_Args_For_Called_Func
		 */
		public static function sanitize( $values, array $registered_fields ) {
			//Set default sanitize function
			$name_of_sanitize_func = 'text_input';

			array_walk( $values, function ( &$value, $name ) use ( $registered_fields, $name_of_sanitize_func ) {
				foreach ( $registered_fields as $field ) {
					if ( in_array( $name, $field ) && ! empty( $field['sanitize_callback'] ) ) {
						if ( $field['sanitize_callback'] === 'by_pattern_input' ) {
							if ( ! isset( $field['sanitize_pattern'] ) ) {
								throw new Think_Exception_Bad_Args_For_Called_Func( 'Don\'t exist sanitize_pattern argument - its required for \'by_pattern_input\' sanitize type' );
							}

							$value = ( new static() )->by_pattern_input( $field['sanitize_pattern'], $value );
						}

						$name_of_sanitize_func = $field['sanitize_callback'];
					}

					try {
						$value = ( new static() )->{$name_of_sanitize_func}( $value );
					} catch ( Exception $e ) {
						throw new Think_Call_Unexpected_Method_Exception( $e->getMessage() );
					}
				}
			} );

			unset( $value );

			return $values;
		}
	}
}