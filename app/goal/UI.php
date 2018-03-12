<?php

namespace Dinet\Goal;

use Dinet\Util;
use Dinet\UtilPath;
use Dinet\UtilWP;

require_once UtilPath::getGoalPath( 'models/Goal' );
require_once UtilPath::getGoalPath( 'controllers/GoalCtrl' );

class UI
{
    public function __construct()
    {

    }

    public function loadJS()
    {
        UtilWP::loadJS( 'goal', UtilPath::getJSPath( 'goal' ), ['jquery'] );
    }

    public function displayGoals( $userId = null )
    {
        $userId = isset( $userId ) ? $userId : get_current_user_id();

        $goal = new GoalCtrl();
        $goals = $goal->getAll($userId);

        $display['addGoal'] = true;

        include UtilPath::getViewsPath('goal' );
    }
}