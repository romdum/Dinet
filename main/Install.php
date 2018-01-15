<?php

namespace Dinet;

//require_once "Dinet_create_table.php";

class Install
{
    /**
     * Plugin installation
     */
    public static function install()
    {
        /*
         * Add table: customer, food
         */
        //$tableGenerator = new Dinet_create_table();
        //$tableGenerator->createFoodUsersTable();
        //$tableGenerator->createFoodTable();
        //$tableGenerator->addContentFoodTable();

        /*
         * Add parameter dinet in options table to know if the plugin is installed
         */
        $GLOBALS['wpdb']->insert(
            $GLOBALS['wpdb']->prefix . "options",
            array("option_name" => "dinet")
        );
    }

    /**
     * Function called when the plugin is activate
     */
    public static function activate()
    {
        // Install the plugin if it's not
        if ( ! self::isInstalled() )
        {
            self::install();
        }

        /*
         * Pages post_status becomes open
         */

        // Customers connection page
        $GLOBALS['wpdb']->update(
            $GLOBALS['wpdb']->prefix . "posts",
            array("post_status" => "draft"),
            array("post_name" => NAME_CUSTOMER_CONNECTION_PAGE)
        );

    }

    /**
     * Function called when the plugin is deactivate
     */
    public static function deactivate()
    {

    }

    /**
     * Uninstall plugin
     */
    public static function uninstall()
    {
        /*
         * Drop tables
         */
        $GLOBALS['wpdb']->query("DROP TABLE `". Dinet::$table_food ."`, `". Dinet::$table_food_users ."`");

        /*
         * Remove parameters in options table
         */
        $GLOBALS['wpdb']->delete(
            $GLOBALS['wpdb']->prefix . "options",
            array("option_name" => "dinet")
        );
    }

    /**
     * Return true if the plugin is already installed
     * @return boolean
     */
    public static function isInstalled()
    {
	    return $GLOBALS['wpdb']->get_results( "SELECT option_value FROM {$GLOBALS['wpdb']->prefix}options WHERE option_name = 'dinet'" ) !== null ;
    }
}
