<?php

namespace Dinet\Patient;

use Dinet\Dinet;
use Dinet\UtilPath;

require_once UtilPath::getPatientPath( 'repository/PatientRepository' );
require_once UtilPath::getPatientPath( 'controller/BMICtrl' );
require_once UtilPath::getPatientPath( 'controller/WeightHistoryCtrl' );
require_once UtilPath::getPatientPath( 'model/Weight' );
require_once UtilPath::getPatientPath( 'WeightHistoryChart' );
require_once UtilPath::getPatientPath( 'PatientSettings' );

class PatientCtrl
{
	const AUTO_LOAD = [
		Dinet::SLUG . 'Observation' => 'Observation',
		Dinet::SLUG . 'Phone'       => 'Phone',
		Dinet::SLUG . 'Height'      => 'Height',
		'first_name'                => 'FirstName',
		'last_name'                 => 'LastName',
	];

	/** @var Patient */
    private $Patient;

    /** @var PatientSettings */
    public $settings;

    /** @var PatientRepository */
    private $repository;

    /** @var BMICtrl */
    private $bmi;

    /** @var WeightHistoryCtrl */
    private $weightHistory;

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
	        ->setWeight( ( new Weight() )->setValue( $_POST['Weight'] )->setTimestamp( time() ) );

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

    public function getWeightHistory() : WeightHistoryCtrl
    {
    	if( ! isset( $this->weightHistory ) )
	    {
		    $this->weightHistory = new WeightHistoryCtrl( $this->getPatient() );
	    }
    	return $this->weightHistory;
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
			$this->bmi = new BMICtrl( $this->getPatient()->getHeight(), $this->getPatient()->getWeight()->getValue() );
		}

		return $this->bmi;
	}

	public function load() : void
	{
		$this->autoLoad();

		$this->Patient->setWeight( $this->getWeightHistory()->getFirst() );

		$this->settings = new PatientSettings( $this->Patient->getUserId() );
	}

	private function autoLoad()
	{
		$metadata = get_metadata( 'user', $this->Patient->getUserId() );

		foreach( self::AUTO_LOAD as $key => $method )
		{
			$method = 'set' . $method;

			if( isset( $metadata[$key] ) && method_exists( $this->Patient, $method ) )
			{
				$this->Patient->{$method}( $metadata[$key][0] );
			}
		}
	}
}
