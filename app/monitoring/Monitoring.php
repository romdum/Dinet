<?php

namespace Dinet\Monitoring;

use Dinet\UtilPath;

require_once UtilPath::getMonitoringPath( 'FoodMonitoringChart' );
require_once UtilPath::getMonitoringModelsPath( 'Food' );
require_once UtilPath::getMonitoringCtrlPath( 'FoodListCtrl' );
require_once UtilPath::getMonitoringPath( 'UI' );
require_once UtilPath::getMonitoringCtrlPath( 'ConsumptionCtrl' );
require_once UtilPath::getMonitoringCtrlPath( 'ConsumptionListCtrl' );
require_once UtilPath::getMonitoringModelsPath( 'ConsumptionList' );
require_once UtilPath::getMonitoringModelsPath( 'Consumption' );

class Monitoring
{
	public function load()
	{
	    $FoodList = new FoodListCtrl();
	    $ConsumptionCtrl = new ConsumptionCtrl();
		add_action( 'wp_ajax_saveWithAjax', array( $ConsumptionCtrl, 'saveWithAjax' ) );
		add_action( 'wp_ajax_food_pagination', array( $FoodList, 'pagination_food' ) );
		add_action( 'wp_ajax_food_search', array( $FoodList, 'food_search' ) );
		add_action( 'wp_ajax_ajax_remove_eaten_food', array( $ConsumptionCtrl, 'deleteWithAjax' ) );

		$UI = new UI();

        //load script
        add_action( 'init', array( $UI, 'loadScript' ) );

        // add plugin menu
        add_action( 'admin_menu', array( $UI, 'dinet_add_plugin_menu' ) );
        add_action( 'admin_bar_menu', array( $UI, 'add_admin_menu_item' ), 80 );
	}
}