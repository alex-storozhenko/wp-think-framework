<?php

if ( ! interface_exists( 'Think_Template' ) ) {
	/**
	 * Contract for view elements render
	 *
	 * Interface Think_Template
	 *
	 * @package wp-think-framework
	 */
	interface Think_Template {
		public static function render( array $data );
	}
}