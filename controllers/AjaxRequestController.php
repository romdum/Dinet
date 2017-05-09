<?php

class AjaxRequestController
{
    /**
	 * Ajax request called when users change food page
	 */
	function pagination_food()
	{
		global $wpdb;

		$page = $_POST["page"];

		$q = $wpdb->get_results(
			"SELECT * FROM {$wpdb->prefix}dinet_food ORDER BY Désignation LIMIT {$page},10"
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
			"SELECT * FROM {$wpdb->prefix}dinet_food WHERE Désignation LIKE \"%{$search}%\" ORDER BY Désignation LIMIT 0,10"
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
			$GLOBALS['wpdb']->prefix . "dinet_food_users",
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
}
