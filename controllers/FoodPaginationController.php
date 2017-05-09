<?php

class FoodPaginationController
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
        	"SELECT * FROM {$wpdb->prefix}dinet_food ORDER BY Désignation LIMIT {$this->page},10"
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
}
