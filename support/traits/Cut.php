<?php


if ( ! trait_exists( 'Cut' ) ) {
	/** Trait Cut */
	trait Cut {

		/**
		 * Cut prefix
		 *
		 * @param string $name
		 *
		 * @return string
		 */
		private function cut_prefix( $name ) {
			$tmp = explode( "_", $name );

			unset( $tmp[0] );

			return implode( '_', $tmp );
		}
	}
}