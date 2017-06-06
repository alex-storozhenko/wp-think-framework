<?php

if ( ! defined( 'ABSPATH' ) ) {
	http_response_code( 403 ) && wp_die( 'Access forbidden' );
}

require __DIR__ . '/utility/autoload.php';

/** @const string version of framework */
define( 'THINK_FRAMEWORK_VERSION', '1.8.4' );

define( 'THINK_FRAMEWORK_PATH', trailingslashit( dirname( __FILE__ ) ) );
define( 'THINK_FRAMEWORK_URI', get_template_directory_uri() . '\/' . basename( THINK_FRAMEWORK_PATH ) );

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
	}
}

//Init framework instance
Think_Framework::get_instance();