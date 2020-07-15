<?php

if ( ! trait_exists( 'Think_Auto_Ajax' ) ) {
	/**
	 * Trait Think_Auto_Ajax.
	 *
	 * Search all method with ajax_ prefix and register them as WP AJAX action
	 *
	 * Example: SomeClass->ajax_action_name() will be registered as
	 * add_action('wp_ajax_action_name', [SomeClass, 'action_name'])
	 * add_action('wp_ajax_nopriv_action_name', [SomeClass, 'action_name'])
	 */
	trait Think_Auto_Ajax {
		public function ajax_register() {
			$r_api   = new \ReflectionClass( get_class( $this ) );
			$methods = $r_api->getMethods();

			if ( ! empty( $methods ) ) {
				foreach ( $methods as $method ) {
					$methodName = $method->name;

					if ( preg_match( '/^ajax_/i', $methodName ) ) {
						$action_name        = 'wp_ajax_' . Think_Helper::cut_prefix( $methodName );
						$action_nopriv_name = 'wp_ajax_nopriv_' . Think_Helper::cut_prefix( $methodName );

						add_action( $action_name, [ $this, $methodName ] );
						add_action( $action_nopriv_name, [ $this, $methodName ] );
					}
				}
			}
		}
	}
}
