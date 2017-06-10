<?php

if ( ! trait_exists( 'Think_Can_Verify_Nonce' ) ) {
	/**
	 * Nonce verify wrapper
	 *
	 * Trait Think_Can_Verify_Nonce
	 *
	 * @package wp-think-framework
	 */
	trait Think_Can_Verify_Nonce {
		/**
		 * Check nonce protection
		 *
		 * @param $nonce
		 * @param $action
		 *
		 * @return bool
		 */
		protected function verify_nonce( $nonce, $action ) {
			return wp_verify_nonce( $nonce, $action );
		}
	}
}