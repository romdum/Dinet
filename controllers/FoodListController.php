<?php

class FoodListController
{
    private $page;
    private $foods = [];

    public function __construct()
    {
        $this->find_page();
        $this->fill_food_array();
    }

    public function get_page()
    {
        return $this->page;
    }

    public function get_food()
    {
        return $this->foods;
    }

    private function find_page()
    {
        if ( isset( $_GET["dinet_p"] ) && $_GET["dinet_p"] > 0 )
        {
        	$this->page = $_GET["dinet_p"];
        }
        else
        {
        	$this->page = 0;
        }
    }

    private function fill_food_array()
    {
        global $wpdb;

        $q = $wpdb->get_results(
        	"SELECT * FROM " . Dinet::$table_food . " ORDER BY Désignation LIMIT {$this->page},10"
        	, ARRAY_A
        );

        foreach ( $q as $food_info )
        {
            $this->add_food( new Food( $food_info["id"], $food_info["Désignation"], $food_info["Groupe"] ) );
        }
    }

    private function add_food( $Food )
    {
        array_push($this->foods, $Food);
    }

    /**
	 * Ajax request called when users change food page
	 */
	function pagination_food()
	{
		global $wpdb;

		$this->page = $_POST["page"];

		$q = $wpdb->get_results(
			"SELECT * FROM " . Dinet::$table_food . " ORDER BY Désignation LIMIT {$this->page},10"
			, ARRAY_A );

		echo json_encode( $q );

		wp_die();
	}

    /**
	 * Ajax request called when users search a food
	 */
	function food_search()
	{
		global $wpdb;

		$search = $_POST["search"];

		$q = $wpdb->get_results(
			"SELECT * FROM " . Dinet::$table_food . " WHERE Désignation LIKE \"%{$search}%\" ORDER BY Désignation LIMIT 0,10"
			, ARRAY_A );

		echo json_encode( $q );

		wp_die();
	}


	/**
	 * Ajax request called when users add food in they monitoring
	 */
	function add_eaten_food()
	{
		$user_id  = get_current_user_id();
		$food_id  = $_POST["food_id"];
		$quantity = htmlspecialchars( $_POST["quantity"] );

		$GLOBALS["wpdb"]->insert(
			Dinet::$table_food_users,
			array(
				"user_id"  => $user_id,
				"food_id"  => $food_id,
				"quantity" => $quantity,
				"eat_date" => date( "Y-m-d" ),
			)
		);

		echo json_encode( array(
			"datasets" => ChartController::getDataset(),
		) );

		wp_die();
	}

    function get_last_eaten_food( $user_id = null, $limit = -1 )
    {
        if( $user_id === null ) $user_id = get_current_user_id();
        $sql = '
            SELECT *
            FROM ' . Dinet::$table_food . '
            JOIN ' . Dinet::$table_food_users . ' ON ' . Dinet::$table_food . '.id = ' . Dinet::$table_food_users . '.food_id
            WHERE ' . Dinet::$table_food_users . '.user_id = \'' . $user_id . '\'
            ORDER BY eat_date DESC';

        if( $limit !== -1 )
        {
            $sql .= ' LIMIT ' . $limit;
        }

        return $GLOBALS['wpdb']->get_results( $sql, ARRAY_A );
    }

    function ajax_remove_eaten_food()
    {
        $GLOBALS['wpdb']->delete(
            Dinet::$table_food_users,
            ['id' => $_POST['conso_id']]
        );

        echo json_encode( array(
			"datasets" => ChartController::getDataset(),
		) );

        wp_die();
    }
}
