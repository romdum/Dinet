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

namespace Dinet;

use Dinet\Consultation\Consultation;
use Dinet_customer;


require_once "main/Install.php";
require_once "main/UI.php";
require_once "Dinet_customer.php";
require_once "consultation/Consultation.php";
require_once 'main/utils/utilDate.php';

require_once "controllers/PostRequestController.php";

define( "PLUGIN_URL", plugin_dir_url( __FILE__ ) );
define( "PLUGIN_PATH", plugin_dir_path( __FILE__ ) );

class Dinet
{
    public static $table_food, $table_food_users;

	function __construct()
	{
		self::$table_food = $GLOBALS["wpdb"]->prefix . "dinet_food";
		self::$table_food_users = $GLOBALS["wpdb"]->prefix . "dinet_food_users";

		// install / uninstall
		register_activation_hook( __FILE__, array( 'Install', 'activate' ) );
		register_deactivation_hook( __FILE__, array( 'Install', 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( 'Install', 'uninstall' ) );

		add_action( 'init', array( $this, 'loadScript' ), 10, 0 );

        new Consultation();
		new Dinet_customer();
		new UI();

		load_plugin_textdomain( 'dinet', false, basename( dirname( __FILE__ ) ) . '/lang'  );
	}

	public function loadScript()
	{
		wp_register_style( 'plugin-dinet-style', PLUGIN_URL . 'style.css' );
		wp_enqueue_style( 'plugin-dinet-style' );
	}
}

new Dinet();
