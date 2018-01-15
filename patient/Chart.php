<?php
/**
 * Created by PhpStorm.
 * User: romain
 * Date: 07/01/18
 * Time: 17:35
 */

namespace Dinet\Patient;

class Chart extends \Dinet\Chart
{
	private $userId;

	public function __construct( int $userId = null )
	{
		$this->userId = $userId === null ? get_current_user_id() : $userId;
	}

	public function getDataset()
	{
		$dataset = [];

		$d = ( new Patient( $this->userId ) )->get_weight_history();

		foreach ( $this->getValueAttributes() as $label => $color )
		{
			$data = [];

			foreach ( array_reverse( $d ) as $item )
				array_push( $data, $item );

			array_push( $dataset, [
				"label"            => $label,
				"borderColor"      => $color,
				"data"             => $data,
			] );
		}

		return $dataset;
	}

	public function getValueAttributes()
	{
		return [
			'Poids' => 'rgba(80 , 227, 28 , 1)'
		];
	}
}