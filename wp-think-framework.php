<?php

if ( ! defined( 'ABSPATH' ) ) {
	http_response_code( 403 ) && wp_die( 'Access forbidden' );
}

require __DIR__ . '/utility/autoload.php';

/** @const string version of framework */
define( 'THINK_FRAMEWORK_VERSION', '1.14.0' );

if ( ! class_exists( 'Think_Framework' ) ) {
	/**
	 * Framework installer
	 *
	 * Class Think_Framework
	 *
	 * @package wp-think-framework
	 */
	final class Think_Framework {
		use Think_Singleton;

		/** Think_Framework constructor */
		private function __construct() {
			/* Define constants path and uri */
			define( 'THINK_FRAMEWORK_PATH', $this->get_path() );
			define( 'THINK_FRAMEWORK_URI', $this->get_uri() );

			/* Autoload components */
			require __DIR__ . '/contracts/autoload.php';
			require __DIR__ . '/exceptioons/autoload.php';
			require __DIR__ . '/support/autoload.php';
			require __DIR__ . '/inputs/autoload.php';
			require __DIR__ . '/customizer/autoload.php';
			require __DIR__ . '/metabox/autoload.php';
			require __DIR__ . '/options/autoload.php';

			add_action( 'after_setup_theme', array( $this, 'multi_language_support' ) );
		}

		/** Add multi language support */
		public function multi_language_support() {
			$mo_file_path = THINK_FRAMEWORK_PATH . '/languages/' . get_locale() . '.mo';

			load_textdomain( 'wp-think-framework', $mo_file_path );
		}

		/**
		 * Get Think_Framework uri
		 *
		 * @return mixed
		 */
		public function get_uri() {
			// Get correct URL and path to wp-content
			$content_url = untrailingslashit( dirname( dirname( get_stylesheet_directory_uri() ) ) );
			$content_dir = untrailingslashit( WP_CONTENT_DIR );

			// Fix path on Windows
			$dir         = wp_normalize_path( dirname( __FILE__ ) );
			$content_dir = wp_normalize_path( $content_dir );

			$uri = str_replace( $content_dir, $content_url, $dir );

			return $uri;
		}

		/**
		 * Get Think_Framework path
		 *
		 * @return string
		 */
		public function get_path() {
			return trailingslashit( dirname( __FILE__ ) );
		}
	}
}