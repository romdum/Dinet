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
    }

    /**
     * Ajax
     */
    public function saveRequest()
    {
        check_ajax_referer( 'nonceGoal','nonce' );

        $this->setGoalFromArray( array_map( function( $elem ){ return htmlspecialchars( $elem ); }, $_POST ) );

        $this->save();

        echo json_encode([
            $this->goal
        ]);
        wp_die();
    }

    public function save()
    {
        global $wpdb;
        $result = $wpdb->insert(
            $wpdb->usermeta,
            [
                'user_id'    => $this->goal->getUserId(),
                'meta_key'   => 'dinet_goal',
                'meta_value' => $this->goal->getDate() . '||' . $this->goal->getDescription() . '||' . $this->goal->isDone()
            ]
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
}