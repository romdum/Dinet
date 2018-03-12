<?php

namespace Dinet\Goal;

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
    public function getAll( int $userId )
    {
        global $wpdb;
        $queryGoals = $wpdb->get_results( $wpdb->prepare(
            "SELECT * FROM {$wpdb->usermeta} WHERE meta_key = 'dinet_goal' AND user_id = '%d'", $userId ), ARRAY_A );

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
            ->setId( $data['goalId'] )
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
        $this->setGoalFromArray( $_POST );

        $this->save();

        echo json_encode([
            $this->goal
        ]);
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
}