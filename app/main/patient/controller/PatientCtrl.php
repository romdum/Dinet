<?php

namespace Dinet\Patient;

use Dinet\UtilDate;
use Dinet\UtilPath;

require_once UtilPath::getPatientPath( 'repository/PatientRepository' );
require_once UtilPath::getPatientPath( 'controller/BMICtrl' );
require_once UtilPath::getPatientPath( 'PatientLoader' );
require_once UtilPath::getPatientPath( 'WeightHistoryChart' );

class PatientCtrl
{
    use PatientLoader;

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

    /** @var PatientRepository */
    private $repository;

    /** @var BMICtrl */
    private $bmi;

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

        $postPatientId = 'patientId';
        if( isset( $_POST[$postPatientId] ) && $_POST[$postPatientId] !== $this->getPatient()->getUserId() )
        {
            $this->Patient = new Patient( $_POST[$postPatientId] );
        }
        else
        {
            $this->Patient = new Patient();
        }

        $this->Patient
	        ->setFirstName( $_POST['FirstName'] )
	        ->setLastName( $_POST['LastName'] )
	        ->setHeight( $this->reformatHeight( $_POST['Height'] ) )
	        ->setObservation( $_POST['Observation'] )
	        ->setPhone( $_POST['Phone'] )
	        ->setWeight( $_POST['Weight'] );

        $this->getRepository()->save( $this->Patient );
        $this->load();

        $result = [];
        $Chart = new WeightHistoryChart();
        $Chart->setPatientCtrl( $this );

        $result['dataset'] = $Chart->getDataset();
        $result['labels']  = $Chart->getXLabels();

        $result['bmi']['number']    = $this->getBMI()->getBmi();
        $result['bmi']['color']     = $this->getBMI()->getColor();
        $result['bmi']['comment']   = $this->getBMI()->getComment();
        $result['bmi']['font_size'] = $this->getBMI()->getFontSize();

        echo json_encode( $result );
        wp_die();
    }

    public function getWeightHistory( int $length = -1 ) : array
    {
    	$result = $this->getRepository()->getWeightHistory( $this->getPatient() );

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

    public function getSettings(): ?PatientSettings
    {
        return $this->settings;
    }

    public function getRepository(): PatientRepository
    {
    	if( ! isset( $this->repository ) )
	    {
	    	$this->repository = new PatientRepository();
	    }
	    return $this->repository;
    }

    public function reformatHeight( $height ): float
    {
	    $height = floatval( str_replace( ",", ".", $height ) );
	    return $height > 3 ? $height / 100 : $height;
    }

	public function getBMI()
	{
		if( ! isset( $this->bmi ) )
		{
			$this->bmi = new BMICtrl( $this->getPatient()->getHeight(), $this->getPatient()->getWeight() );
		}

		return $this->bmi;
	}
}