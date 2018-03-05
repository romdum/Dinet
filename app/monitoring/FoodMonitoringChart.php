<?php

namespace Dinet\Monitoring;

use DateInterval;
use DateTime;
use Dinet\Dinet;
use Dinet\Chart;
use Dinet\UtilDate;

require_once plugin_dir_path( __FILE__ ) . '../main/Chart.php';

class FoodMonitoringChart extends Chart
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

			foreach ( $d as $item )
            {
                $data[] = isset( $item[ $label ] ) ? $item[ $label ] : 0;
            }

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
		$food = Dinet::$TABLE_FOOD;
		$foodUser = Dinet::$TABLE_FOOD_USER;
        $dates = $this->getXLabelsValue();

		for ( $i = 0; $i < $count; $i ++ )
		{
            $d1 = date(UtilDate::TIME_FORMAT_EN, $dates[$i][0] );
            $d2 = date(UtilDate::TIME_FORMAT_EN, $dates[$i][1] + UtilDate::ONE_DAY );

			$result .= "
                SELECT
			      SUM((`energy` * fu.quantity /100)) AS {$labels[0]},
			      SUM((`water` * fu.quantity /100)) AS {$labels[1]},
			      SUM((`protein` * fu.quantity /100)) AS {$labels[2]},
			      SUM((`glucid` * fu.quantity /100)) AS {$labels[3]},
			      SUM((`lipid` * fu.quantity /100)) AS {$labels[4]},
			      SUM((`sugar` * fu.quantity /100)) AS {$labels[5]}
			    FROM {$food} AS f
			      JOIN {$foodUser} AS fu ON f.id = food_id
			    WHERE user_id = {$this->userId}
			    AND fu.eat_date BETWEEN '{$d1}' AND '{$d2}'";

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

    public function getXLabels()
    {
        $dates = $this->getXLabelsValue();

        return [
            'du '. date('d', $dates[0][0] ) . ' au ' . date('d', $dates[0][1] ),
            'du '. date('d', $dates[1][0] ) . ' au ' . date('d', $dates[1][1] ),
            'du '. date('d', $dates[2][0] ) . ' au ' . date('d', $dates[2][1] ),
            'du '. date('d', $dates[3][0] ) . ' au ' . date('d', $dates[3][1] )
        ];
    }

    private function getXLabelsValue(): array
    {

        $dateTime = new DateTime();
        $dateTime->setTime(0,0,0 );

        return [
            [
                UtilDate::firstDayOfWeek( $dateTime->sub( new DateInterval( 'P3W' ) ) ), // - 3 weeks
                UtilDate::lastDayOfWeek( $dateTime )
            ],
            [
                UtilDate::firstDayOfWeek( $dateTime->add( new DateInterval( 'P1W' ) ) ), // + 1 week
                UtilDate::lastDayOfWeek( $dateTime ),
            ],
            [
                UtilDate::firstDayOfWeek( $dateTime->add( new DateInterval( 'P1W' ) ) ),
                UtilDate::lastDayOfWeek( $dateTime ),
            ],
            [
                UtilDate::firstDayOfWeek(),
                UtilDate::lastDayOfWeek()
            ],
        ];
    }
}