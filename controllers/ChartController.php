<?php

/**
 * Created by Romain DUMINIL.
 * Date: 17/04/17
 */
class ChartController
{
	private $Chart;
	private $chartData;

	public function __construct( $Chart )
	{
		$this->Chart = $Chart;

		if( $Chart->getDataType() === Chart::FOOD_MONITORING )
		{
			$Chart->setXLabels( $this->getXLabelsFoodMonitoring() );
			$Chart->setValueAttributes( $this->getValuesAttributesFoodMonitoring() );
		}
		else if ( $Chart->getDataType() === Chart::WEIGHT_HISTORY )
		{
			$Chart->setValueAttributes( $this->getValueAttributeWeightHistory() );
		}
	}

	public function getDataset( $user_id = null )
	{
		global $wpdb;
		$dataset = [];

		if( $this->Chart->getDataType() === Chart::FOOD_MONITORING )
		{
			$d = $wpdb->get_results( $this->getFoodMonitoringData( 4, $user_id ), ARRAY_A );
		}
		else if( $this->Chart->getDataType() === Chart::WEIGHT_HISTORY )
		{
			$Patient = new Patient( $user_id );
			$d = $Patient->get_weight_history();
		}

		foreach ( $this->Chart->getValueAttributes() as $label => $color )
		{
			$data = [];

			foreach ( array_reverse( $d ) as $item )
			{
				if( $this->Chart->getDataType() === Chart::WEIGHT_HISTORY )
				{
					array_push( $data, $item );
				}
				else if( $this->Chart->getDataType() === Chart::FOOD_MONITORING && isset( $item[ $label ] ))
				{
					array_push( $data, $item[ $label ] );
				}
				else
				{
					array_push( $data, 0 );
				}
			}

			array_push( $dataset, [
				"label"            => $label,
				"borderColor"      => $color,
				"data"             => $data,
			] );
		}

		return $dataset;
	}


	private function getFoodMonitoringData( $count = 1, $user_id = null )
	{
		$pre = $GLOBAL['wpdb'];
		$result = "";
		$labels = array_keys( $this->Chart->getValueAttributes() );
		$user_id = $user_id === null ? get_current_user_id() : $user_id;
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
		    WHERE user_id = {$user_id}
		    AND fu.eat_date BETWEEN '{$d1}' AND '{$d2}'";

			$d1 = date("Y-m-d",strtotime($d1) - (7*24*60*60));
			$d2 = date("Y-m-d",strtotime($d2) - (7*24*60*60));

			if($i+1 !== $count){
				$result .= " UNION ALL ";
			}
		}

		return $result;
	}

	private function getValuesAttributesFoodMonitoring()
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

	private function getValueAttributeWeightHistory()
	{
		return [
			'Poids' => 'rgba(80 , 227, 28 , 1)'
		];
	}

	private function getXLabelsFoodMonitoring()
	{
		return [
			'du '. firstDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 21 ) ) ) . ' au ' . lastDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 21 ) ) ),
			'du '. firstDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 14 ) ) ) . ' au ' . lastDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 14 ) ) ),
			'du '. firstDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 7 ) ) ) . ' au ' . lastDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 7 ) ) ),
			'du '. firstDayOfWeek() . ' au ' . lastDayOfWeek()
		];
	}
}
