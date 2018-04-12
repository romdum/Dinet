<?php

/**
 * Plugin Name: Dinet
 * Plugin URI:
 * Description: De la diet' sur le net !
 * Version: 0.0.1
 * Author: Romain DUMINIL, Mathilde PETITPEZ
 * Author URI: duminil.eu
 * Licence: GPLv2 or later
 */

namespace Dinet;

use Dinet\Consultation\Consultation;
use Dinet\Monitoring\Monitoring;
use Dinet\Patient\Patient;
use Dinet\Patient\PatientCtrl;
use Goal;

require_once plugin_dir_path( __FILE__ ) . 'app/main/utils/UtilPath.php';
require_once UtilPath::getUtilsPath( 'Util' );
require_once UtilPath::getUtilsPath( 'UtilDate' );
require_once UtilPath::getUtilsPath( 'UtilWP' );
require_once UtilPath::getMainPath( 'Installer' );
require_once UtilPath::getMainPath( 'UI' );
require_once UtilPath::getMainPath( 'Settings' );
require_once UtilPath::getMainPath( 'SettingsEnum' );
require_once UtilPath::getMainPath( 'Citation' );
require_once UtilPath::getPatientPath( 'model/Patient' );
require_once UtilPath::getPatientPath( 'controller/PatientCtrl' );

class Dinet
{
    const NAME = 'Dinet';
    const SLUG = 'dinet';
    const DB_VERSION = '1.0';

    /** @var string */
    public static $TABLE_FOOD, $TABLE_FOOD_USER;

    /** @var Settings */
    public static $setting;

    public function load() : void
    {
        $this->loadStaticVar();
        $this->loadHook();

        $mainUI = new UI();
        $mainUI->load();

        if( self::$setting->getSetting( SettingsEnum::CONSULTATION, SettingsEnum::ACTIVATE ) )
        {
            require_once UtilPath::getConsultationPath('Consultation' );
            $Consultation = new Consultation();
            $Consultation->load();
        }

        if( self::$setting->getSetting( SettingsEnum::MONITORING, SettingsEnum::ACTIVATE ) )
        {
            require_once UtilPath::getMonitoringPath( 'Monitoring' );
            $Monitoring = new Monitoring();
            $Monitoring->load();
        }

        if( self::$setting->getSetting( SettingsEnum::GOAL, SettingsEnum::ACTIVATE ) )
        {
            require_once UtilPath::getGoalPath( 'UI' );
            $Goal = new \Dinet\Goal\UI();
        }
    }

    public function loadScript() : void
    {
        wp_register_style( 'plugin-dinet-style', plugin_dir_url( __FILE__ ) . 'style.css' );
        wp_enqueue_style( 'plugin-dinet-style' );
    }

    private function loadHook() : void
    {
        register_activation_hook( __FILE__, array( '\Dinet\Installer', 'activate' ) );
        register_deactivation_hook( __FILE__, array( Installer::NAME, 'deactivate' ) );
        register_uninstall_hook( __FILE__, array( Installer::NAME, 'uninstall' ) );

        add_action( 'init', array( $this, 'loadScript' ), 10, 0 );

        $PatientCtrl = new PatientCtrl();
        $PatientCtrl->setPatient( new Patient() );
        add_action( 'wp_ajax_ajaxSavePatient', array( $PatientCtrl, 'ajaxSavePatient' ) );
    }

    private function loadStaticVar() : void
    {
        self::$TABLE_FOOD      = $GLOBALS["wpdb"]->prefix . 'dinet_food';
        self::$TABLE_FOOD_USER = $GLOBALS["wpdb"]->prefix . 'dinet_food_users';

        self::$setting = new Settings();
    }
}

if( is_admin() )
{
	$Dinet = new Dinet();
	$Dinet->load();
}
