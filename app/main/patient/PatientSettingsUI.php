<?php

namespace Dinet\Patient;

use Dinet\SettingsEnum;
use Dinet\UtilPath;

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
            add_action( 'admin_init', array( $this, 'page_init' ) );

            $this->PatientCtrl = new PatientCtrl();
            $this->PatientCtrl->setPatient( new Patient( $_GET['patient_id'] ) );
            $this->PatientCtrl->load();
        }
    }

    /**
     * Options page callback
     */
    public function createSettingsPage()
    {
        ?>
        <div class="wrap">
            <h1>Paramètre du patient <?= $this->PatientCtrl->getPatient()->getFirstName() . ' ' . $this->PatientCtrl->getPatient()->getLastName() ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( PatientSettings::NAME );
                do_settings_sections( 'dinet_patient_settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            PatientSettings::NAME, // Option group
            $this->PatientCtrl->getSettings()->getOptionName(), // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'monitoring', // ID
            'Suivi nutritionnel', // Title
            null, // Callback
            'dinet_patient_settings' // Page
        );

        add_settings_field(
            'monitorin_activate', // ID
            'Activer', // Title
            array( $this, 'id_number_callback' ), // Callback
            'dinet_patient_settings', // Page
            'monitoring' // Section
        );

        add_settings_field(
            'title',
            'Title',
            array( $this, 'title_callback' ),
            'dinet_patient_settings',
            'monitoring'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     * @return array
     */
    public function sanitize( $input )
    {
        $new_input = array();
        var_dump(' '.$input);
        if( isset( $input['Monitoring']['activate'] ) )
            $new_input['Monitoring']['activate'] = $input['Monitoring']['activate'];

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="checkbox" id="id_number" name="'. $this->PatientCtrl->getSettings()->getOptionName() .'[Monitoring][activate]" %s />',
            $this->PatientCtrl->getSettings()->getSetting( SettingsEnum::MONITORING, SettingsEnum::ACTIVATE ) ? 'checked' : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}