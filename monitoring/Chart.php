<?php

namespace Dinet\Monitoring;

use DateTime;
use Dinet\Dinet;
use Dinet\Patient\Patient;

class Chart extends \Dinet\Chart
{
	private $userId;

	public function __construct( int $userId = null )
	{
		$this->userId = $userId === null ? get_current_user_id() : $userId;
	}

	public function getDataset()
	{
		global $wpdb;
		$dataset = [];

		$d = $wpdb->get_results( $this->getSQLQuery( count( $this->getXLabels() ) ), ARRAY_A );

		foreach ( $this->getValueAttributes() as $label => $color )
		{
			$data = [];

			foreach ( array_reverse( $d ) as $item )
				$data[] = isset( $item[ $label ] ) ? $item[ $label ] : 0;

			$dataset[] = [
				"label"            => $label,
				"borderColor"      => $color,
				"data"             => $data,
			];
		}

		return $dataset;
	}

	private function getSQLQuery( $count = 1 )
	{
		$result = "";
		$labels = array_keys( $this->getValueAttributes() );
		$d1 = date('Y-m-d', strtotime('-'. date('w').' days') + (24*60*60));
		$d2 = date('Y-m-d', strtotime('+'.(6-date('w')).' days') + (24*60*60));

		for ( $i = 0; $i < $count; $i ++ )
		{
			$result .= "SELECT
			      SUM((`Energie (kcal/100g)` * fu.quantity /100)) AS {$labels[0]},
			      SUM((`Eau (g/100g)` * fu.quantity /100)) AS {$labels[1]},
			      SUM((`Protéines (g/100g)` * fu.quantity /100)) AS {$labels[2]},
			      SUM((`Glucides (g/100g)` * fu.quantity /100)) AS {$labels[3]},
			      SUM((`Lipides (g/100g)` * fu.quantity /100)) AS {$labels[4]},
			      SUM((`Sucres (g/100g)` * fu.quantity /100)) AS {$labels[5]}
			    FROM " . Dinet::$table_food . " AS f
			      JOIN " . Dinet::$table_food_users . " AS fu ON f.id = food_id
			    WHERE user_id = {$this->userId}
			    AND fu.eat_date BETWEEN '{$d1}' AND '{$d2}'";

			$d1 = date("Y-m-d",strtotime($d1) - (7*24*60*60));
			$d2 = date("Y-m-d",strtotime($d2) - (7*24*60*60));

			if($i+1 !== $count){
				$result .= " UNION ALL ";
			}
		}

		return $result;
	}

	public function getValueAttributes()
	{
		return [
			"Energie"  => "rgba(80 , 227, 28 , 1)",
			"Eau"      => "rgba(0  , 209, 255, 1)",
			"Proteine" => "rgba(249, 78 , 186, 1)",
			"Glucide"  => "rgba(220, 220, 220, 1)",
			"Lipide"   => "rgba(255, 230, 0  , 1)",
			"Sucre"    => "rgba(255, 133, 33 , 1)",
		];
	}
}