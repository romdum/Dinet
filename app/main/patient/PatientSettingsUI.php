<?php

namespace Dinet\Patient;

use Dinet\SettingsEnum;
use Dinet\UtilPath;
use Dompdf\Exception;

require_once UtilPath::getPatientPath( 'controller/PatientCtrl' );
require_once UtilPath::getPatientPath( 'model/Patient' );

class PatientSettingsUI
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    private $PatientCtrl;

    public function __construct()
    {
        if( isset( $_GET['patient_id'] ) )
        {
            $this->PatientCtrl = new PatientCtrl();
            $this->PatientCtrl->setPatient( new Patient( $_GET['patient_id'] ) );
            $this->PatientCtrl->load();
        }
    }

    /**
     * Register and add settings
     */
    public function pageInit()
    {
        include UtilPath::getTemplatesPath( 'patientSettings' );
    }

    private function displaySettings( $settings, $key = '', $level = 2 )
    {
        foreach( $settings as $label => $setting )
        {
            if( method_exists( $this, 'get' . ucfirst( gettype( $setting ) ) . 'Field' ) )
            {
                $this->{'get' . ucfirst( gettype( $setting ) ) . 'Field'}( $setting, ucfirst( $label ), $key . '{' . $label . '}', $level );
            }
        }
    }

    protected function getBooleanField( $setting, $label, $key )
    {
        include UtilPath::getViewsPath( 'settings/booleanField' );
    }

    protected function getArrayField( $setting, $label, $key, $level )
    {
        echo '<h' . $level . '>' .  ucfirst( $label ) . '</h' . $level . '>';
        $this->displaySettings( $setting, $key, $level + 1 );
    }

    protected function getStringField( $setting, $label, $key )
    {
        echo '<label>' . $key . '</label>';
        echo '<input type="text" value="' . $setting. '">';
    }

    public function patientSettingsSave()
    {
        // TODO implement this method
        // create array like default settings from POST
        // compare with default settings
        // add if necessary default settings
        // save PatientSettings::setSettings
        wp_redirect( admin_url( 'admin.php?page=dinet_patient_settings&patient_id=' . $_POST['patient_id'] ) );
    }
}