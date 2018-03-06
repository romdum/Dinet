<?php

namespace Dinet\Patient;

use Dinet\UtilDate;
use Dinet\UtilPath;

require_once UtilPath::getPatientPath( 'PatientSaver' );
require_once UtilPath::getPatientPath( 'PatientLoader' );
require_once UtilPath::getPatientPath( 'PatientBMI' );

class PatientCtrl
{
    use PatientSaver;
    use PatientLoader;
    use PatientBMI;

    const AUTO_LOAD = [
        'Height',
        'Observation',
        'Phone'
    ];

    const AUTO_SAVE = [
        'Observation',
        'Phone'
    ];

    /** @var Patient */
    private $Patient;

    /** @var PatientSettings */
    public $settings;

    /**
     * @return Patient
     */
    public function getPatient(): Patient
    {
        $this->Patient = isset( $this->Patient ) ? $this->Patient : new Patient();
        return $this->Patient;
    }

    public function setPatient( $Patient ): void
    {
        $this->Patient = $Patient;
    }

    public function ajaxSavePatient(): void
    {
        check_ajax_referer( isset( $_POST['nonceName'] ) ? $_POST['nonceName'] : 'fail', 'nonce' );
        require_once UtilPath::getPatientPath( 'WeightHistoryChart' );

        $postPatientId = 'patientId';
        if( isset( $_POST[$postPatientId] ) && $_POST[$postPatientId] !== $this->getPatient()->getUserId() )
        {
            $this->Patient = new Patient( $_POST[$postPatientId] );
        }
        else
        {
            $this->Patient = new Patient();
        }

        $this->save( $_POST );
        $this->load();

        $result = [];
        $Chart = new WeightHistoryChart();
        $Chart->setPatientCtrl( $this );

        $result['dataset'] = $Chart->getDataset();
        $result['labels']  = $Chart->getXLabels();

        $result['bmi']['number']    = $this->getImc();
        $result['bmi']['color']     = $this->getImcColor();
        $result['bmi']['comment']   = $this->getImcComment();
        $result['bmi']['font_size'] = $this->getImcFontSize();

        echo json_encode( $result );
        wp_die();
    }

    public function getWeightHistory( int $length = -1 ) : array
    {
        global $wpdb;
        $sql = "
            SELECT SUBSTR(meta_key,1+LENGTH('dinetWeight_')) AS meta_key, meta_value 
            FROM {$wpdb->usermeta} 
            WHERE meta_key LIKE 'dinetWeight_%' 
            AND user_id = {$this->getPatient()->getUserId()} 
            ORDER BY meta_key DESC;
        ";

        $result = $wpdb->get_results( $sql, ARRAY_A );

        if( ! is_array( $result ) )
        {
            return [];
        }

        if( $length > 0 )
        {
            $result = array_slice( $result, 0, $length );
        }

        return $this->arrayUniqueWeightHistory( $result );
    }

    private function arrayUniqueWeightHistory( array $weightHistory )
    {
        $result = $weightHistory;
        for( $i = 0; $i < count( $weightHistory ); $i++ )
        {
            for( $j = $i+1; $j < count( $weightHistory ); $j++ )
            {
                if( date( UtilDate::DATE_FORMAT_FR, $weightHistory[$i]['meta_key'] ) ===
                    date( UtilDate::DATE_FORMAT_FR, $weightHistory[$j]['meta_key'] ) )
                {
                    unset($result[$j]);
                }
            }
        }
        return $result;
    }
}