<?php


if ( ! class_exists( 'Metabox_Input' ) ) {
	/**
	 * Class Metabox_Input
	 * Abstract class for Composite pattern implementation
	 *
	 * @package think\bundle\metabox\inputs
	 */
	abstract class Metabox_Input {

		/** @var string inputs id */
		public $id;

		/**c@var string $label */
		public $label;

		/**
		 * Metabox_Input constructor.
		 *
		 * @param $id
		 * @param string $label
		 */
		public function __construct( $id, $label = '' ) {
			$this->id    = $id;
			$this->label = $label;
		}

		/**
		 * Because all dynamic metabox data saved in one post meta,
		 * need to have method for getting value by id
		 * @return string
		 */
		public function get_value() {
			global $post;
			$value = get_post_meta( $post->ID, '_think_meta', true );

			return ( ! empty( $value[ $this->id ] ) ) ? $value[ $this->id ] : '';
		}

		/**
		 * Rewrite from extends class
		 *
		 * @return mixed
		 */
		abstract public function render();
	}
}
