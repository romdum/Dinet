<?php

namespace Dinet\Monitoring;

use Dinet\Dinet;
use Dinet\Patient\Patient;
use Dinet\UtilPath;
use Dinet\UtilWP;

class ConsumptionCtrl
{
    /** @var Consumption $Consumption */
    private $Consumption;

    public function getConsumption(): Consumption
    {
        return $this->Consumption;
    }

    public function setConsumption( Consumption $Consumption ): void
    {
        $this->Consumption = $Consumption;
    }

    public function save()
    {
        global $wpdb;

        $wpdb->insert(
            Dinet::$TABLE_FOOD_USER,
            [
                'user_id'        => $this->Consumption->getPatient()->getUserId(),
                'food_id'        => $this->Consumption->getFood()->getId(),
                'quantity'       => $this->Consumption->getQuantity(),
                'eat_date'       => $this->Consumption->getDate(),
                'hungry_level'   => $this->Consumption->getHungryLevel(),
                'feeling_before' => $this->Consumption->getFeelingBefore(),
                'feeling_after'  => $this->Consumption->getFeelingAfter()
            ]
        );

        $this->Consumption->setId( $wpdb->insert_id );
    }

    public function saveWithAjax()
    {
        check_ajax_referer( UtilWP::getNonceName( UI::ADD_EATEN_FOOD_SLUG ), 'nonce' );

        $response = [];
        $this->Consumption = new Consumption();

        $this->Consumption
            ->setFood(
                ( new FoodCtrl() )
                    ->setFood( new Food( $_POST['food_id'] ) )
                    ->load()
                    ->getFood()
            )
            ->setPatient( new Patient() )
            ->setQuantity( htmlspecialchars( $_POST['quantity'] ) )
            ->setDate( $_POST['eat_date']  . ' ' . $_POST['eat_hour'] . ':00' )
            ->setHungryLevel( intval( $_POST['hungry_level'] ) )
            ->setFeelingBefore( htmlspecialchars( $_POST['feeling_before'] ) )
            ->setFeelingAfter( htmlspecialchars( $_POST['feeling_after'] ) );

        $this->save();

        $response['html'] = '';
        $consumption = $this->Consumption;

        $display = [
            'hungryLevel'   => false,
            'feelingBefore' => false,
            'feelingAfter'  => false,
        ];

        ob_start();
        include UtilPath::getViewsPath( 'monitoring/lastFoodRow' );
        $response['html'] = ob_get_clean();

        $response['datasets'] = ( new FoodMonitoringChart() )->getDataset();

        echo json_encode( $response );
        wp_die();
    }

    public function delete()
    {
        global $wpdb;

        $wpdb->delete(
            Dinet::$TABLE_FOOD_USER,
            [
                'id' => $this->Consumption->getId(),
            ]
        );
    }

    public function deleteWithAjax()
    {
        check_ajax_referer( UtilWP::getNonceName( UI::REMOVE_CONSUMPTION ), 'nonce' );

        $response = [];

        $this->Consumption = new Consumption();
        $this->Consumption->setId( $_POST['cons_id'] );

        $this->delete();

        $response['datasets'] = ( new FoodMonitoringChart() )->getDataset();

        echo json_encode( $response );
        wp_die();
    }
}