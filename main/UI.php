<?php

namespace Dinet;

use Dinet\Monitoring\NewFoodController;
use Dinet\Patient\Chart;
use Dinet\Patient\Patient;
use FoodListController;

class UI
{
	public function __construct()
	{
		add_action( 'admin_menu', array( $this, 'addPluginMenu' ) );
	}

	function addPluginMenu()
	{
		add_submenu_page( 'dinet_plugin', 'Administration', 'Administration', 'administrator', 'dinet_admin_page', array( $this, 'displayAdmin' ) );
		add_submenu_page( 'dinet_plugin', 'Fiche patient', 'Fiche patient', 'administrator', 'dinet_patient_record', array( $this, 'displayPatientRecord' ) );
		add_submenu_page( 'dinet_plugin', 'Ajouter un aliment', 'Ajouter un aliment', 'administrator', 'dinet_add_food', array( $this, 'displayAdminAddFood' ) );
	}

	/**
	 * Display plugin's administration page
	 */
	public function displayAdmin()
	{
		include PLUGIN_PATH . "ressources/views/admin/header.php";
		include PLUGIN_PATH . "ressources/views/admin/admin_page.php";
	}

	public function displayPatientRecord()
	{
		if( ! isset( $_GET['patient_id'] ) )
		{
			$this->displayAdmin();
			wp_die();
		}

		$FoodPagination = new FoodListController();
		$limit = -1;
		$Patient = new Patient( $_GET['patient_id'] );
		require_once PLUGIN_PATH . 'patient/Chart.php';
		$Chart = new Chart( $Patient->get_user_id() );
		$Chart->setTitle( 'Evolution du poids' );

		include PLUGIN_PATH . 'ressources/views/admin/header.php';
		echo '<div style="display:flex;">';
		include PLUGIN_PATH . 'ressources/views/admin/patient_record.php';
		include PLUGIN_PATH . 'ressources/views/admin/patient_consultation.php';
		echo '</div>';
		echo '<div style="display:flex;">';
		$Chart->display();
		include PLUGIN_PATH . 'ressources/views/last_food.php';
		echo '</div>';
	}

	/**
	 * Display plugin's administration page which is used to add food
	 */
	function displayAdminAddFood()
	{
		$food = new NewFoodController();
		include PLUGIN_PATH . "ressources/views/admin/header.php";
		include PLUGIN_PATH . "ressources/views/admin/addFood_page.php";
	}
}