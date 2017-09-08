<?php

require_once 'controllers/NewFoodController.php';

class Dinet_admin
{
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'dinet_add_plugin_menu' ) );

        add_action( "admin_post_post_add_food", array( new NewFoodController(), "post_add_food" ) );

        add_action( "admin_post_post_save_patient", array( new PostRequestController(), "post_save_patient" ) );
    }

    function dinet_add_plugin_menu()
    {
        add_submenu_page( 'dinet_plugin', 'Administration', 'Administration', 'administrator', 'dinet_admin_page', array( $this, 'display_dinet_admin' ) );
        add_submenu_page( 'dinet_plugin', 'Fiche patient', 'Fiche patient', 'administrator', 'dinet_patient_record', array( $this, 'display_dinet_patient_record' ) );
        add_submenu_page( 'dinet_plugin', 'Ajouter un aliment', 'Ajouter un aliment', 'administrator', 'dinet_add_food', array( $this, 'display_dinet_admin_add_food' ) );
    }

    function display_dinet_patient_record()
    {
        if( ! isset( $_GET['patient_id'] ) )
        {
            $this->display_dinet_admin();
            wp_die();
        }

        $FoodPagination = new FoodListController();
        $limit = -1;
        $Patient = new Patient( $_GET['patient_id'] );
        $Chart = new Chart( Chart::WEIGHT_HISTORY );
        $Chart->setTitle( 'Evolution du poids' );
        $ChartController = new ChartController( $Chart );

        include 'views/admin/header.php';
        echo '<div style="display:flex;">';
        include 'views/admin/patient_record.php';
        include 'views/admin/patient_consultation.php';
        echo '</div>';
        echo '<div style="display:flex;">';
        include 'views/chart.php';
        include 'views/last_food.php';
        echo '</div>';
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
