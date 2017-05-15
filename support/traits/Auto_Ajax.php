<?php

if ( ! trait_exists( 'Auto_Ajax' ) ) {
	/**
	 * Trait Auto_Ajax
	 *
	 * Search all method with ajax_ prefix and register them as WP AJAX action
	 *
	 * Example: SomeClass->ajax_action_name() will be registered as
	 * add_action('wp_ajax_action_name', [SomeClass, 'action_name'])
	 * add_action('wp_ajax_nopriv_action_name', [SomeClass, 'action_name'])
	 */
	trait Auto_Ajax {
		use Cut;

		public function ajax_register() {
			$r_api   = new \ReflectionClass( static::class );
			$methods = $r_api->getMethods();

			if ( ! empty( $methods ) ) {
				foreach ( $methods as $method ) {
					$methodName = $method->name;

					if ( preg_match( "/^ajax_/i", $methodName ) ) {
						$action_name        = 'wp_ajax_' . $this->cut_prefix( $methodName );
						$action_nopriv_name = 'wp_ajax_nopriv_' . $this->cut_prefix( $methodName );

						add_action( $action_name, [ static::class, $methodName ] );
						add_action( $action_nopriv_name, [ static::class, $methodName ] );
					}
				}
			}
		}
	}
}