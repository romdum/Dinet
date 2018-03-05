<?php

namespace Dinet\Monitoring;

use Dinet\Dinet;
use Dinet\Patient\Patient;

class ConsumptionListCtrl
{
    /** @var ConsumptionList $consumptionList */
    private $consumptionList;

    /** @var Patient $patient */
    private $patient;

    public function __construct()
    {
        $this->consumptionList = new ConsumptionList();
    }

    public function getConsumptionList(): ConsumptionList
    {
        return $this->consumptionList;
    }

    public function fillList(): void
    {
        $userId = $this->patient->getUserId();
        $food = Dinet::$TABLE_FOOD;
        $foodUser = Dinet::$TABLE_FOOD_USER;

        $sql = "
            SELECT *
            FROM {$food}
            JOIN {$foodUser} ON {$food}.id = {$foodUser}.food_id
            WHERE {$foodUser}.user_id = '{$userId}'
            ORDER BY eat_date DESC";

        $q = $GLOBALS['wpdb']->get_results( $sql, ARRAY_A );

        foreach( $q as $value )
        {
            $consumption = new Consumption();
            $consumption
                ->setId( $value['id'] )
                ->setPatient( new Patient( $value['user_id'] ) )
                ->setFood(
                    ( new FoodCtrl() )
                        ->setFood( new Food( $value['food_id'] ) )
                        ->loadFromArray( $value )
                        ->getFood()
                )
                ->setDate( $value['eat_date'] )
                ->setQuantity( $value['quantity'] )
                ->setHungryLevel( $value['hungry_level'] )
                ->setFeelingBefore( $value['feeling_before'] )
                ->setFeelingAfter( $value['feeling_after'] );
            $this->consumptionList->addConsumption( $consumption );
        }
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function setPatient( Patient $patient ): void
    {
        $this->patient = $patient;
    }
}