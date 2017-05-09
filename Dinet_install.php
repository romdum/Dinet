<?php

require_once "Dinet_create_table.php";


class Dinet_install
{
    /**
     * Plugin installation
     */
    public function install()
    {
        /*
         * Add table: customer, food
         */
        $tableGenerator = new Dinet_create_table();
        $tableGenerator->createFoodUsersTable();
        $tableGenerator->createFoodTable();
        $tableGenerator->addContentFoodTable();

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
    public function activate()
    {
        // Install the plugin if it's not
        if (!$this->isInstalled())
        {
            $this->install();
        }
        // debug mode
        if ($_SERVER["HTTP_HOST"] === "localhost")
        {
            $this->install();
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
    public function deactivate()
    {
	    // debug mode
	    if ($_SERVER["HTTP_HOST"] === "localhost")
	    {
		    $this->uninstall();
	    }
    }

    /**
     * Uninstall plugin
     */
    public function uninstall()
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
    public function isInstalled()
    {
	    return $GLOBALS['wpdb']->get_results( "SELECT option_value FROM {$GLOBALS['wpdb']->prefix}options WHERE option_name = 'dinet'" ) !== null ;
    }
}
