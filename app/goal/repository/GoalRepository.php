<?php

namespace Dinet\Goal;

class GoalRepository
{
	/**
	 * Get all goals of one user
	 *
	 * @param int $userId
	 * @return array
	 * @throws \TypeError
	 */
	public function getAll( $userId )
	{
		global $wpdb;
		$queryGoals = $wpdb->get_results( $wpdb->prepare(
			"SELECT * FROM {$wpdb->usermeta} WHERE meta_key = 'dinet_goal' AND user_id = '%d'", $userId ),
			ARRAY_A );

		return array_map( function($val){
			return ( new Goal() )
				->setId( $val['umeta_id'] )
				->setDate( explode( '||', $val['meta_value'] )[0] )
				->setDescription( explode( '||', $val['meta_value'] )[1] )
				->setDone( explode( '||', $val['meta_value'] )[2] );
		}, $queryGoals );
	}

	public function findById( $goalId )
	{
		global $wpdb;
		$data = $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM {$wpdb->usermeta} WHERE umeta_id = %d", $goalId
		), ARRAY_A);

		return ( new Goal() )
			->setId( $data['umeta_id'] )
			->setUserId( $data['user_id'] )
			->setDate( explode( '||', $data['meta_value'] )[0] )
			->setDescription( explode( '||', $data['meta_value'] )[1] )
			->setDone( explode( '||', $data['meta_value'] )[2] );

	}

	/**
	 * Add new goal in database
	 *
	 * @param Goal $goal
	 *
	 * @return false|int : id created on success
	 */
	public function add( Goal $goal )
	{
		return add_user_meta(
			$goal->getUserId(),
			'dinet_goal',
			$goal->getDate() . '||' . $goal->getDescription() . '||' . $goal->isDone()
		);
	}

	public function update( Goal $goal )
	{
		global $wpdb;
		$wpdb->update(
			$wpdb->usermeta,
			[
				'meta_value' => $goal->getDate() . '||' . $goal->getDescription() . '||' . $goal->isDone()
			],
			[
				'umeta_id' => $goal->getId()
			]
		);
	}
}