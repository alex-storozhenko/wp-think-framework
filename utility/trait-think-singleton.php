<?php

if ( ! trait_exists( 'Think_Singleton' ) ) {
	/**
	 * Realization singleton pattern
	 *
	 * Trait Singleton
	 *
	 * @package wp-think-framework
	 */
	trait Think_Singleton {

		/**
		 * @var $instance
		 *
		 * Container for only one exemplar of @self
		 *
		 * According with realization singleton
		 */
		static private $instance = null;

		/**
		 * Singleton constructor
		 * The ban on the creation of a class outside
		 *
		 * According with realization singleton
		 */
		private function __construct() {
		}

		/**
		 * Method returned only one exemplar of @self
		 *
		 * According with realization singleton
		 *
		 * @return mixed
		 */
		public static function get_instance() {
			if ( null === static::$instance ) {
				static::$instance = new self();
			}

			return static::$instance;
		}

		/**
		 * Ban on cloning
		 *
		 * According with realization singleton
		 */
		private function __clone() {
		}

		/**
		 * The ban on unserialization from outside the class
		 *
		 * According with realization singleton
		 */
		private function __wakeup() {
		}
	}
}
