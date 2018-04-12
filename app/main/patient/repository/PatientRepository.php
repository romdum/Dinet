<?php

namespace Dinet\Patient;

use Dinet\Dinet;

class PatientRepository
{
	const AUTO_SAVE = [
		Dinet::SLUG . 'Observation' => 'Observation',
		Dinet::SLUG . 'Phone'       => 'Phone',
		Dinet::SLUG . 'Height'      => 'Height',
		'first_name'                => 'FirstName',
		'last_name'                 => 'LastName',
	];

	public function findAll()
	{

	}

	public function getWeightHistory( Patient $patient )
	{
		global $wpdb;
		$sql = "
            SELECT SUBSTR(meta_key,1+LENGTH('dinetWeight_')) AS meta_key, meta_value 
            FROM {$wpdb->usermeta} 
            WHERE meta_key LIKE 'dinetWeight_%' 
            AND user_id = {$patient->getUserId()} 
            ORDER BY meta_key DESC;
        ";
		return $wpdb->get_results( $sql, ARRAY_A );
	}

	public function save( Patient $patient )
	{
		$this->autoSave( $patient );

		update_user_meta(
			$patient->getUserId(),
			'dinetWeight_' . time(),
			htmlspecialchars( $patient->getWeight() )
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