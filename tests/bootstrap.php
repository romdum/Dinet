<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Dinet
 */

defined('DB_NAME') || define( 'DB_NAME', getenv('DB_NAME') );
defined('DB_USER') || define( 'DB_USER', getenv('DB_USER') );
defined('DB_PASSWORD') || define( 'DB_PASSWORD', getenv('DB_PASSWORD') );
defined('DB_HOST') || define( 'DB_HOST', getenv('DB_HOST') );
defined('DB_CHARSET') || define( 'DB_CHARSET', getenv('DB_CHARSET') );
defined('DB_COLLATE') || define( 'DB_COLLATE', getenv('DB_COLLATE') );

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	echo "Could not find $_tests_dir/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL;
	exit( 1 );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/Dinet.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';
