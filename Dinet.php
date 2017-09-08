<?php

/**
 * Plugin Name: Dinet
 * Plugin URI:
 * Description: Plugin permettant de gerer la consommation alimentaire des patients
 * Version: 0.0.1
 * Author: Romain DUMINIL, Mathilde PETITPEZ
 * Author URI: duminil.eu
 * Licence: GPLv2 or later
 */

require_once "Dinet_install.php";
require_once "Dinet_admin.php";
require_once "Dinet_customer.php";
require_once "Dinet_consultation.php";
require_once 'utils/utilDate.php';

require_once "controllers/PostRequestController.php";

define( "PLUGIN_PATH", plugin_dir_url( __FILE__ ) );

class Dinet
{
    public static $table_food, $table_food_users;

	function __construct()
	{
		self::$table_food = $GLOBALS["wpdb"]->prefix . "dinet_food";
		self::$table_food_users = $GLOBALS["wpdb"]->prefix . "dinet_food_users";

		// install / uninstall
		register_activation_hook( __FILE__, array( new Dinet_install(), 'activate' ) );
		register_deactivation_hook( __FILE__, array( new Dinet_install(), 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( new Dinet_install(), 'uninstall' ) );

		// load stylesheet
		wp_register_style( 'plugin-dinet-style', PLUGIN_PATH . 'style.css' );
		wp_enqueue_style( 'plugin-dinet-style' );

        new Dinet_consultation();
		new Dinet_customer();
		new Dinet_admin();
	}
}

new Dinet();
