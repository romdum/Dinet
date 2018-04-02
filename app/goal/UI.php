<?php

namespace Dinet\Goal;

use Dinet\Util;
use Dinet\UtilPath;
use Dinet\UtilWP;

require_once UtilPath::getGoalPath( 'models/Goal' );
require_once UtilPath::getGoalPath( 'controllers/GoalCtrl' );

class UI
{
    private $goal;

    public function __construct()
    {
        $this->goal = new GoalCtrl();

        add_action( 'init', array( $this, 'loadJS' ) );
        add_action( 'wp_ajax_goalSaveRequest', array( $this->goal, 'saveRequest' ) );
    }

    public function loadJS()
    {
        UtilWP::loadJS( 'goal', UtilPath::getJSPath( 'goal.min' ), ['jquery'] );
    }

    public function displayGoals( $userId = null )
    {
        $this->goal->getGoal()->setUserId(isset( $userId ) ? $userId : get_current_user_id() );

        $goals = $this->goal->getAll();

        $display['addGoal'] = true;

        include UtilPath::getViewsPath('goal' );
    }
}