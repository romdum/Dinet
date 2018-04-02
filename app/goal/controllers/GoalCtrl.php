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
    public function getAll()
    {
        global $wpdb;
        $queryGoals = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM {$wpdb->usermeta} WHERE meta_key = 'dinet_goal' AND user_id = '%d'", $this->goal->getUserId() ),
        ARRAY_A );

        return array_map( function($val){
            return [
                'id'          => $val['umeta_id'],
                'date'        => explode( '||', $val['meta_value'] )[0],
                'description' => explode( '||', $val['meta_value'] )[1],
                'done'        => explode( '||', $val['meta_value'] )[2]
            ];
        }, $queryGoals );
    }

    private function setGoalFromArray( array $data )
    {
        $this->goal = ( new Goal() )
//            ->setId( $data['goalId'] )
            ->setDate( $data['goalDate'] )
            ->setDone( $data['goalDone'] )
            ->setDescription( $data['goalDescription'] )
            ->setUserId( isset( $data['goalUserId'] ) ? $data['goalUserId'] : $this->getGoal()->getUserId() );
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
        $wpdb->insert(
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