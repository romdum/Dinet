<?php

/**
 * Created by Romain DUMINIL.
 * Date: 17/04/17
 */
class ChartController
{
	public static function getDataset()
	{
		global $wpdb;
		$labels          = [
			"Energie"  => "rgba(80 , 227, 28 , 1)",
			"Eau"      => "rgba(0  , 209, 255, 1)",
			"Proteine" => "rgba(249, 78 , 186, 1)",
			"Glucide"  => "rgba(220, 220, 220, 1)",
			"Lipide"   => "rgba(255, 230, 0  , 1)",
			"Sucre"    => "rgba(255, 133, 33 , 1)",
		];

		$q = $wpdb->get_results( ChartController::getQuery(4), ARRAY_A );

		$dataset = [];

		foreach ( $labels as $label => $color )
		{
			$data = [];

			foreach ( array_reverse( $q ) as $item )
			{
				array_push( $data, $item[ $label ] === null ? 0 : $item[ $label ] );
			}

			array_push( $dataset, [
				"label"            => $label,
				"borderColor"      => $color,
				"data"             => $data,
			] );
		}

		return $dataset;
	}


	private static function getQuery( $count = 1 )
	{
		global $wpdb;
		$pre = $wpdb->prefix;
		$result          = "";
		$labels          = [ "Energie", "Eau", "Proteine", "Glucide", "Lipide", "Sucre" ];
		$current_user_id = get_current_user_id();
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
		    FROM {$pre}dinet_food AS f
		      JOIN {$pre}dinet_food_users AS fu ON f.id = food_id
		    WHERE user_id = {$current_user_id}
		    AND fu.eat_date BETWEEN '{$d1}' AND '{$d2}'";

			$d1 = date("Y-m-d",strtotime($d1) - (7*24*60*60));
			$d2 = date("Y-m-d",strtotime($d2) - (7*24*60*60));

			if($i+1 !== $count){
				$result .= " UNION ALL ";
			}
		}

		return $result;
	}
}
