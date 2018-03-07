<?php

namespace Dinet;

use Dinet\Monitoring\Citation;
use Dinet\Monitoring\ConsumptionListCtrl;
use Dinet\Monitoring\UI as MonitoringUI;
use Dinet\Monitoring\NewFoodController;
use Dinet\Patient\PatientCtrl;
use Dinet\Patient\WeightHistoryChart;
use Dinet\Patient\Patient;

require_once UtilPath::getPatientPath('WeightHistoryChart');

class UI
{
    const JS_SAVE_PATIENT_SLUG = 'pluginDinetScriptSavePatientRecord';
    const JS_SAVE_PATIENT_NONCE = 'savePatientRecordNonce';

	public function load()
	{
		add_action( 'admin_menu', array( $this, 'addPluginMenu' ), 10, 0 );

		add_action( 'init', array( $this, 'loadScript' ), 10, 0 );
	}

	public function loadScript() : void
	{
	    if( is_admin() )
        {
            wp_register_script( "plugin_dinet_script_util", UtilPath::getJSPath('util' ), array( "jquery" ) );
            wp_enqueue_script( "plugin_dinet_script_util" );

            wp_register_script( self::JS_SAVE_PATIENT_SLUG, UtilPath::getJSPath( 'savePatient' ), array( "jquery" ) );
            wp_localize_script( self::JS_SAVE_PATIENT_SLUG, "SavePatientRecordUtil", array(
                "ajaxurl" => admin_url( "admin-ajax.php" ),
                "nonce"   => wp_create_nonce( self::JS_SAVE_PATIENT_NONCE ),
            ) );
            wp_enqueue_script( self::JS_SAVE_PATIENT_SLUG );
        }
	}

	function addPluginMenu() : void
	{
		if( Dinet::$setting->getSetting( 'Consultation', 'activate' ) || ! user_can( get_current_user_id(), 'administrator' ) )
        {
            add_menu_page( Dinet::NAME, Dinet::NAME, 'read', 'dinet_plugin', array( 'Dinet\Monitoring\UI', 'displayMonitoring' ), 'dashicons-carrot', 26 );
        }
		else
        {
            add_menu_page( Dinet::NAME, Dinet::NAME, 'read', 'dinet_plugin', array( $this, 'displayAdmin' ), 'dashicons-carrot', 26 );
        }

		add_submenu_page( 'dinet_plugin', 'Administration', 'Administration', 'administrator', 'dinet_admin_page', array( $this, 'displayAdmin' ) );
		add_submenu_page( 'dinet_plugin', 'Fiche patient', 'Fiche patient', 'administrator', 'dinet_patient_record', array( $this, 'displayPatientAdministration' ) );
		add_submenu_page( null, 'Paramètres du patient', 'Paramètres du patient', 'administrator', 'dinet_patient_settings', array( $this, 'displayPatientSettings' ) );

//		remove_submenu_page( 'dinet_plugin', 'dinet_patient_settings' );
		remove_submenu_page( 'dinet_plugin', 'dinet_plugin' );
	}

	/**
	 * Display plugin's administration page
	 */
	public function displayAdmin()
	{
		include UtilPath::getViewsPath( 'header' );
		include UtilPath::getViewsPath() . 'admin/admin_page.php';
	}

	public function displayPatientAdministration()
	{
		if( ! isset( $_GET['patient_id'] ) )
		{
			$this->displayAdmin();
			wp_die();
		}

        $limit = -1;
		$PatientCtrl = new PatientCtrl();
        $PatientCtrl->setPatient( new Patient( $_GET['patient_id'] ) );
        $PatientCtrl->load();

		$nonceName = self::JS_SAVE_PATIENT_NONCE;

		$Chart = new WeightHistoryChart();
		$Chart->setPatientCtrl( $PatientCtrl );
		$Chart->setTitle( 'Evolution du poids' );

		if( Dinet::$setting->getSetting( SettingsEnum::MONITORING, SettingsEnum::ACTIVATE ) )
		{
			$ConsumptionList = new ConsumptionListCtrl();
			$ConsumptionList->setPatient( $PatientCtrl->getPatient() );
			$ConsumptionList->fillList();
		}

        $display = [
            'trash' => false
        ];

        include UtilPath::getTemplatesPath( 'patientAdministration' );
	}

	public function displayPatientSettings()
    {
        $PatientCtrl = new PatientCtrl();
        $PatientCtrl->setPatient( new Patient( $_GET['patient_id'] ) );
        $PatientCtrl->load();

        include UtilPath::getTemplatesPath( 'patientSettings' );
    }
}