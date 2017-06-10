<?php

if ( ! interface_exists( 'Think_Fields_Walker' ) ) {
	/**
	 * Fields Walker
	 *
	 * Interface Think_Fields_Walker
	 *
	 * @package wp-think-framework
	 */
	interface Think_Fields_Walker {
		public function walk();
	}
}
