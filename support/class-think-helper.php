<?php

if ( ! class_exists( 'Think_Helper' ) ) {
	/**
	 * Helper.
	 *
	 * Class Think_Helper
	 */
	class Think_Helper {
		/**
		 * Render string from array.
		 *
		 * @param $key
		 * @param $array
		 * @param string $default
		 *
		 * @return string|mixed
		 */
		public static function str_render_from_array( $key, $array, $default = '' ) {
			return ( ! array_key_exists( $key, $array ) || ! $array[ $key ] ) ? __( $default, 'wp-think-framework' ) : $array[ $key ];
		}

		/**
		 * Convert snake to kebab.
		 *
		 * @param $snake_str
		 *
		 * @return string
		 */
		public static function str_snake_to_kebab( $snake_str ) {
			return mb_strtolower( str_replace( '_', '-', trim( $snake_str ) ), 'UTF-8' );
		}

		/**
		 * Convert snake to camel.
		 *
		 * @param $snake_str
		 *
		 * @return mixed
		 */
		public static function str_snake_to_camel( $snake_str ) {
			$arr = explode( '_', strtolower( $snake_str ) );

			for ( $i = 0, $c = count( $arr ); $i < $c; $i ++ ) {
				if ( $i > 0 ) {
					$arr[ $i ] = ucfirst( $arr[ $i ] );
				}
			}

			return implode( '', $arr );
		}

		/**
		 * Cut prefix.
		 *
		 * @param string $name
		 *
		 * @return string
		 */
		public static function cut_prefix( $name ) {
			$tmp = explode( '_', $name );

			unset( $tmp[0] );

			return implode( '_', $tmp );
		}
	}
}
