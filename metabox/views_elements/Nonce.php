<?php


if ( ! class_exists( 'Nonce' ) ) {
	/**
	 * Class Nonce
     *
	 * Render CSRF field
	 */
	class Nonce extends Metabox_Input {

		/**
		 * Render field with nonce
		 */
		public function render() {
			?>
            <div style="display:none"><?= $this->label; ?></div>
            <div><?php wp_nonce_field( $this->id, '_think_meta[' . $this->id . ']', false ); ?></div><?php
		}
	}
}