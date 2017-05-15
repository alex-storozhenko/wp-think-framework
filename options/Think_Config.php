<?php

if ( ! class_exists( 'Think_Config' ) ) {
	/** Configurations */
	class Think_Config {

		/** @var array $options */
		protected static $options = array();

		/**
		 * Get config
		 *
		 * @param string $key
		 *
		 * @return null|array
		 */
		final public static function get_config( $key ) {
			if ( ! isset( static::$options[ $key ] ) ) {
				static::$options[ $key ] = null;
			};

			return static::$options[ $key ];
		}

		/**
		 * Set options
		 *
		 * @param array $options
		 */
		public static function set_options( array $options ) {
			static::$options = $options;
		}
	}
}