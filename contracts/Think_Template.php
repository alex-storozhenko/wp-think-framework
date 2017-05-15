<?php

if ( ! interface_exists( 'Think_Template' ) ) {
	/** Interface Template */
	interface Think_Template {
		public static function render( array $data );
	}
}