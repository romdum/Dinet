<?php

namespace Dinet\Patient;

use Dinet\UtilDate;
use Dinet\UtilPath;

require_once UtilPath::getPatientPath( 'repository/WeightHistoryRepository' );

class WeightHistoryCtrl
{
	private $repo;
	private $values;
	private $patient;

	public function __construct( Patient $patient )
	{
		$this->patient = $patient;
		$this->repo    = new WeightHistoryRepository();
	}

	public function getValues( int $length = -1 ) : array
	{
		$result = $this->repo->getWeightHistory( $this->patient );
		$weightHistory = [];

		if( $length > 0 )
		{
			$result = array_slice( $result, 0, $length );
		}

		foreach( $result as $weight )
		{
			$weightHistory[] = ( new Weight() )
				->setTimestamp( $weight['meta_key'] )
				->setValue( $weight['meta_value'] );
		}

		$this->values = $this->arrayUniqueWeightHistory( $weightHistory );
		return $this->values;
	}

	private function arrayUniqueWeightHistory( array $weightHistory ): array
	{
		$result = $weightHistory;
		for( $i = 0; $i < count( $weightHistory ); $i++ )
		{
			for( $j = $i+1; $j < count( $weightHistory ); $j++ )
			{
				if( date( UtilDate::DATE_FORMAT_FR, $weightHistory[$i]->getTimestamp() ) ===
				    date( UtilDate::DATE_FORMAT_FR, $weightHistory[$j]->getTimestamp() ) )
				{
					unset($result[$j]);
				}
			}
		}
		return $result;
	}

	public function getFirst(): Weight
	{
		$data =	$this->repo->getFirst( $this->patient );

		return ( new Weight() )
			->setTimestamp( intval( $data['meta_key'] ) )
			->setValue( floatval( $data['meta_value'] ) );
	}
}
