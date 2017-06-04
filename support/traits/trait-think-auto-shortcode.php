<?php

if ( ! trait_exists( 'Think_Auto_Shortcode' ) ) {
	/**
	 * Trait Think_Auto_Shortcode
	 *
	 * Search all method with shortcode_ prefix and register them as WP shortcodes
	 *
	 * Example: SomeClass->shortcode_some_name() will be registered as
	 * add_shortcode('some_name', [SomeClass, 'some_name']) and can be used with
	 * do_shortcode('[some_name]');
	 *
	 * @package wp-think-framework
	 */
	trait Think_Auto_Shortcode {
		public function shortcodes_register() {
			$r_api   = new \ReflectionClass( static::class );
			$methods = $r_api->getMethods();

			if ( ! empty( $methods ) ) {
				foreach ( $methods as $method ) {
					$method_name = $method->name;

					if ( preg_match( "/^shortcode_/i", $method_name ) ) {
						$shortcode_name = Think_Helper::cut_prefix( $method_name );

						add_shortcode( $shortcode_name, [ static::class, $method_name ] );
					}
				}
			}
		}
	}
}