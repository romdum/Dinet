<?php

use Dinet\Monitoring\Citation;
use Dinet\Patient\BMIPatient;
use Dinet\Patient\Patient;

require_once "monitoring/Citation.php";
require_once "monitoring/FoodListController.php";
require_once "patient/BMIPatient.php";
require_once "monitoring/Food.php";
require_once "patient/Patient.php";
require_once "main/Chart.php";
require_once "monitoring/Chart.php";

class Dinet_customer
{
    public static $config;

	function __construct()
	{
        self::$config = json_decode( file_get_contents( PLUGIN_PATH . "config.json" ) )->customer;

		//load script
		add_action( "init", array( $this, "load_script" ) );

		add_action( "wp_ajax_add_eaten_food", array( new FoodListController(), "add_eaten_food" ) );
		add_action( "wp_ajax_food_pagination", array( new FoodListController(), "pagination_food" ) );
		add_action( "wp_ajax_food_search", array( new FoodListController(), "food_search" ) );
		add_action( "wp_ajax_ajax_remove_eaten_food", array( new FoodListController(), "ajax_remove_eaten_food" ) );

		// add plugin menu
		add_action( 'admin_menu', array( $this, 'dinet_add_plugin_menu' ) );
		add_action( "admin_bar_menu", array( $this, "add_admin_menu_item" ), 80 );

		//form info submit
		add_action( "admin_post_post_add_info", array( new PostRequestController(), "post_add_info" ) );
	}

	function load_script()
	{
		wp_register_script( "plugin_dinet_script_util", PLUGIN_URL . "ressources/js/util.js", array( "jquery" ) );
		wp_enqueue_script( "plugin_dinet_script_util" );

		wp_register_script( "plugin_dinet_script_add_eaten_food", PLUGIN_URL . "ressources/js/add_eaten_food.js", array( "jquery" ) );
		wp_localize_script( "plugin_dinet_script_add_eaten_food", "myAjax", array(
			"ajaxurl" => admin_url( "admin-ajax.php" ),
			"nonce"   => wp_create_nonce( "add_eaten_food_nonce" ),
		) );
		wp_enqueue_script( "plugin_dinet_script_add_eaten_food" );

		wp_register_script( "plugin_dinet_script_pagination", PLUGIN_URL . "ressources/js/food_pagination.js", array( "jquery" ) );
		wp_localize_script( "plugin_dinet_script_pagination", "myAjax", array(
			"ajaxurl" => admin_url( "admin-ajax.php" ),
			"nonce"   => wp_create_nonce( "pagination_nonce" ),
		) );
		wp_enqueue_script( "plugin_dinet_script_pagination" );

		wp_register_script( "plugin_dinet_script_search", PLUGIN_URL . "ressources/js/search.js", array( "jquery" ) );
		wp_localize_script( "plugin_dinet_script_search", "myAjax", array(
			"ajaxurl" => admin_url( "admin-ajax.php" ),
			"nonce"   => wp_create_nonce( "search_nonce" ),
		) );
		wp_enqueue_script( "plugin_dinet_script_search" );

		wp_register_script( "plugin_dinet_script_remove_eaten_food", PLUGIN_URL . "ressources/js/remove_eaten_food.js", array( "jquery" ) );
		wp_localize_script( "plugin_dinet_script_remove_eaten_food", "myAjax", array(
			"ajaxurl" => admin_url( "admin-ajax.php" ),
			"nonce"   => wp_create_nonce( "search_nonce" ),
		) );
		wp_enqueue_script( "plugin_dinet_script_remove_eaten_food" );
	}

	function dinet_add_plugin_menu()
	{
		add_menu_page( "Dinet", "Dinet", "read", "dinet_plugin", array(
			$this,
			"display_dinet",
		), "dashicons-carrot", 26 );
        add_submenu_page( 'dinet_plugin', 'Mon suivi', 'Mon suivi', 'read', 'dinet_monitoring_page', array( $this, 'display_dinet' ) );
		remove_submenu_page( 'dinet_plugin', 'dinet_plugin' );
	}

	function add_admin_menu_item( WP_Admin_Bar $wp_admin_bar )
	{
		$wp_admin_bar->add_node( array(
			'id'    => 'dinet_admin_menu_item',
			'title' => 'Mon suivi',
			'href'  => admin_url( "admin.php?page=dinet_plugin" ),
		) );
	}

	/**
	 * Display plugin's customers page
	 */
	function display_dinet()
	{
		$Citation = new Citation();
		$Patient = new Patient();
		$BMI = new BMIPatient( $Patient );
		$FoodPagination = new FoodListController();
        $limit = 5;

		include "ressources/views/customer/header.php";
		if( self::$config->display_chart )
		{
			$Chart = new Dinet\Monitoring\Chart();
			$Chart->setTitle( 'Consommation mensuelle' );
            echo '<main>';
			$Chart->display();

		}
		if( self::$config->display_bmi )
		{
			include "ressources/views/customer/imc.php";
		}
		include "ressources/views/customer/form_info.php";
		include "ressources/views/last_food.php";
		include "ressources/views/customer/add_eaten_food.php";
	}
}
