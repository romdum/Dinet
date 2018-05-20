<?php

namespace Dinet\Patient;

use Dinet\Dinet;

class PatientRepository
{
	const AUTO_SAVE = [
		Dinet::SLUG . 'Observation'     => 'Observation',
		Dinet::SLUG . 'Phone'           => 'Phone',
		Dinet::SLUG . 'Height'          => 'Height',
		'first_name'                    => 'FirstName',
		'last_name'                     => 'LastName',
		Dinet::SLUG . 'Job'             => 'Job',
		Dinet::SLUG . 'DateOfBirth'     => 'DateOfBirth',
		Dinet::SLUG . 'FamilialHistory' => 'FamilialHistory',
		Dinet::SLUG . 'MedicalHistory'  => 'MedicalHistory',
	];

	public function save( Patient $patient )
	{
		$this->autoSave( $patient );

		update_user_meta(
			$patient->getUserId(),
			'dinetWeight_' . $patient->getWeight()->getTimestamp(),
			htmlspecialchars( $patient->getWeight()->getValue() )
		);
	}

	private function autoSave( Patient $patient )
	{
		foreach( self::AUTO_SAVE as $key => $method )
		{
			if( method_exists( $patient, 'get' . $method ) && $patient->{'get'.$method}() !== null )
			{
				update_user_meta(
					$patient->getUserId(),
					$key,
					htmlspecialchars( $patient->{'get'.$method}() )
				);
			}
		}
	}
}
