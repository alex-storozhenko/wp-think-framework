<?php

if ( ! trait_exists( 'Think_Singleton' ) ) {
	/**
	 * Realization singleton pattern.
	 *
	 * Trait Singleton
	 */
	trait Think_Singleton {
		/**
		 * @var
		 *
		 * Container for only one exemplar of @self
		 *
		 * According with realization singleton
		 */
		protected static $instance = null;

		/**
		 * Singleton constructor
		 * The ban on the creation of a class outside.
		 *
		 * According with realization singleton
		 */
		protected function __construct() {
			//
		}

		/**
		 * Method returned only one exemplar of @self.
		 *
		 * According with realization singleton
		 *
		 * @return mixed
		 */
		public static function get_instance() {
			if ( null === static::$instance ) {
				static::$instance = new static();
			}

			return static::$instance;
		}

		/**
		 * Ban on cloning.
		 *
		 * According with realization singleton
		 */
		private function __clone() {
			//
		}

		/**
		 * The ban on unserialization from outside the class.
		 *
		 * According with realization singleton
		 */
		protected function __wakeup() {
			//
		}
	}
}
