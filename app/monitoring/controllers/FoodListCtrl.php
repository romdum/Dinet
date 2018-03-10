<?php

namespace Dinet\Monitoring;

use Dinet\Dinet;
use Dinet\UtilPath;
use Dinet\UtilWP;

require_once UtilPath::getMonitoringModelsPath('FoodList');
require_once UtilPath::getMonitoringCtrlPath('FoodCtrl');

class FoodListCtrl
{
    private $page;

    /** @var FoodList */
    private $foodList;

    public function __construct()
    {
    	$this->foodList = new FoodList();

        $this->findPage();
        $this->fillList( $this->page );
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getFoodList()
    {
        return $this->foodList;
    }

    private function findPage()
    {
        $getPage = 'dinet_p';
	    $this->page = isset( $_GET[$getPage] ) && $_GET[$getPage] > 0 ? $_GET[$getPage] : 0;
    }

    private function fillList( int $offset = 0, int $length = 10, $condition = '' ) : void
    {
        global $wpdb;
        $food = Dinet::$TABLE_FOOD;

        $q = $wpdb->get_results( $wpdb->prepare(
        	"SELECT * FROM {$food} WHERE 1=1 {$condition} ORDER BY designation LIMIT %d, %d"
        ,[$offset,$length] ), ARRAY_A );

        foreach ( $q as $foodInfo )
        {
            $foodCtrl = new FoodCtrl();
            $foodCtrl->setFood( new Food( $foodInfo['id'] ) );
            $foodCtrl->load();
            $this->foodList->addFood( $foodCtrl->getFood() );
        }
    }

    /**
	 * Ajax request called when users change food page
	 */
	public function pagination_food()
	{
	    check_ajax_referer( 'noncePagination', 'nonce' );

		$this->page = $_POST["page"];
        $this->foodList = new FoodList();

		$this->fillList( $_POST["page"], 10 );

		echo json_encode( $this->getFoodList()->getList() );

		wp_die();
	}


    /**
	 * Ajax request called when users search a food
	 */
	public function food_search()
	{
        check_ajax_referer( UtilWP::getNonceName( UI::FOOD_SEARCH_SLUG ), 'nonce' );

		$search = $_POST["search"];
        $this->foodList = new FoodList();
        $condition = '';

        if( strlen( $search ) > 3 )
        {
            $condition = " AND designation LIKE \"%{$search}%\" ";
        }

        $this->fillList( 0, 10, $condition );

		echo json_encode( $this->getFoodList()->getList() );

		wp_die();
	}
}
