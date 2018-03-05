<?php

namespace Dinet\Monitoring;

use Dinet\Dinet;

require_once plugin_dir_path( __FILE__ ) . '../models/Food.php';

class FoodCtrl
{
	/** @var Food */
	private $food;

	public function load(): FoodCtrl
	{
		global $wpdb;
		$table_food = Dinet::$TABLE_FOOD;

		$values = $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM $table_food WHERE id = '%s'", $this->food->getId() ), ARRAY_A
		);

		$this->loadFromArray( $values );
		return $this;
	}

	public function loadFromArray( array $data ): FoodCtrl
    {
        foreach( $data as $columns => $value )
        {
            if( method_exists( $this->food, 'set' . ucfirst( $columns ) ) )
            {
                $this->food->{'set'.ucfirst( $columns )}( $value );
            }
        }
        return $this;
    }

	public function getFood(): Food
	{
		return $this->food;
	}

	public function setFood( Food $food ): FoodCtrl
	{
		$this->food = $food;
		return $this;
	}

	public function save()
	{
		//TODO: implements this method to save food in DB
	}
}