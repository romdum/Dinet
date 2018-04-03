<?php

namespace Dinet\Goal;

use TypeError;

class GoalCtrl
{
    /** @var Goal */
    private $goal;

    /**
     * Get all goals of one user
     *
     * @param int $userId
     * @return array
     * @throws TypeError
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

    private function setGoalFromArray( array $data )
    {
        $this->goal = ( new Goal() )
//            ->setId( $data['goalId'] )
            ->setDate( $data['goalDate'] )
            ->setDone( $data['goalDone'] )
            ->setDescription( $data['goalDescription'] )
            ->setUserId( $data['goalUserId'] );

        if( isset( $data['goalId'] ) )
        {
        	$this->goal->setId( $data['goalId'] );
        }
    }

    /**
     * Ajax
     */
    public function saveRequest()
    {
        check_ajax_referer( 'nonceGoal','nonce' );

        $this->setGoalFromArray( array_map( function( $elem ){ return htmlspecialchars( $elem ); }, $_POST ) );

        $this->goal->setId( $this->save() );

        echo json_encode([
	        'id' => $this->goal->getId(),
        	'icon' => UI::getUncheckIcon(),
	        'description' => $this->goal->getDescription()
        ]);
        wp_die();
    }

    public function save()
    {
    	return add_user_meta(
		    $this->goal->getUserId(),
		    'dinet_goal',
		    $this->goal->getDate() . '||' . $this->goal->getDescription() . '||' . $this->goal->isDone()
	    );
    }

    public function getGoal(): Goal
    {
        if( ! isset( $this->goal ) )
        {
            $this->goal = new Goal();
        }

        return $this->goal;
    }

    public function loadGoalWithId( $goalId )
    {
    	global $wpdb;
    	$data = $wpdb->get_row( $wpdb->prepare(
    		"SELECT * FROM {$wpdb->usermeta} WHERE umeta_id = %d", $goalId
	    ), ARRAY_A);

		$this->goal = ( new Goal() )
			->setId( $data['umeta_id'] )
			->setUserId( $data['user_id'] )
			->setDate( explode( '||', $data['meta_value'] )[0] )
			->setDescription( explode( '||', $data['meta_value'] )[1] )
			->setDone( explode( '||', $data['meta_value'] )[2] );
    }

    public function setDoneRequest()
    {
		global $wpdb;
	    $this->loadGoalWithId( $_POST['goalId'] );
	    $this->goal->setDone( ! $this->goal->isDone() );

		$wpdb->update(
			$wpdb->usermeta,
			[
				'meta_value' => $this->goal->getDate() . '||' . $this->goal->getDescription() . '||' . $this->goal->isDone()
			],
			[
				'umeta_id' => $this->goal->getId()
			]
		);

		echo json_encode([
			'isDone' => $this->goal->isDone(),
			'icon'   => $this->goal->isDone() ? UI::getCheckIcon() : UI::getUncheckIcon()
		]);

	    wp_die();
    }
}