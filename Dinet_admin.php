<?php

require_once 'controllers/NewFoodController.php';

class Dinet_admin
{
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'dinet_add_plugin_menu' ) );

        add_action( "admin_post_post_add_food", array( new NewFoodController(), "post_add_food" ) );
    }

    function dinet_add_plugin_menu()
    {
        add_menu_page( "Dinet", "Dinet Admin", "administrator", "dinet_admin_plugin", array(
            $this,
            "display_dinet_admin",
        ), "dashicons-carrot", 25 );
        add_plugins_page( "Dinet", "Dinet", "administrator", "dinet_customer", array( $this, "display_dinet_admin_customer" ) );
        add_plugins_page( "Dinet", "Dinet", "administrator", "dinet_add_food", array( $this, "display_dinet_admin_add_food" ) );
    }

    /**
	 * Display plugin's administration page
	 */
    function display_dinet_admin()
    {
        include "views/admin/header.php";
        include "views/admin/admin_page.php";
    }

    /**
	 * Display plugin's administration page which is used to add food
	 */
    function display_dinet_admin_add_food()
    {
        $food = new NewFoodController();
        include "views/admin/header.php";
        include "views/admin/addFood_page.php";
    }
}
