<?php

if ( ! interface_exists( 'Think_Walk_Fields' ) ) {
	/**
	 * Fields Walker Interface
	 *
	 * Interface Think_Fields_Walker
	 *
	 * @package wp-think-framework
	 */
	interface Think_Walk_Fields {
		public function walk( array $fields );
	}
}