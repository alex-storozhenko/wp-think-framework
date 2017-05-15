<?php

if ( ! trait_exists( 'Auto_Shortcode' ) ) {
	/**
	 * Trait Auto_Shortcode
	 *
	 * Search all method with shortcode_ prefix and register them as WP shortcodes
	 *
	 * Example: SomeClass->shortcode_some_name() will be registered as
	 * add_shortcode('some_name', [SomeClass, 'some_name']) and can be used with
	 * do_shortcode('[some_name]');
	 */
	trait Auto_Shortcode {
		use Cut;

		public function shortcodes_register() {
			$r_api   = new \ReflectionClass( static::class );
			$methods = $r_api->getMethods();

			if ( ! empty( $methods ) ) {
				foreach ( $methods as $method ) {
					$method_name = $method->name;

					if ( preg_match( "/^shortcode_/i", $method_name ) ) {
						$shortcode_name = $this->cut_prefix( $method_name );

						add_shortcode( $shortcode_name, [ static::class, $method_name ] );
					}
				}
			}
		}
	}
}