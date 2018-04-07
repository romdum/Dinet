<?php

namespace Dinet\Goal;

use Dinet\Util;
use Dinet\UtilPath;
use Dinet\UtilWP;

require_once UtilPath::getGoalPath( 'models/Goal' );
require_once UtilPath::getGoalPath( 'controllers/GoalCtrl' );
require_once UtilPath::getGoalPath( 'repository/GoalRepository' );

class UI
{
    private $goal;

    public function __construct()
    {
        $this->goal = new GoalCtrl();

        add_action( 'init', array( $this, 'loadJS' ) );
        add_action( 'init', array( $this, 'loadCSS' ) );
        add_action( 'wp_ajax_goalSaveRequest', array( $this->goal, 'saveRequest' ) );
        add_action( 'wp_ajax_goalSetDoneRequest', array( $this->goal, 'setDoneRequest' ) );
    }

    public function loadJS()
    {
	    UtilWP::loadJS( 'goalSelector', UtilPath::getJSPath( 'goal/Selector' ), ['jquery'] );
	    UtilWP::loadJS( 'goalAjax', UtilPath::getJSPath( 'goal/Ajax' ), ['jquery'], [
		    'nonceNewGoal' => wp_create_nonce( 'nonceNewGoal' ),
		    'nonceSetGoalDone' => wp_create_nonce( 'nonceSetGoalDone' )
	    ]);
	    UtilWP::loadJS( 'goal', UtilPath::getJSPath( 'goal/Goal' ), ['jquery'] );
	    UtilWP::loadJS( 'goalInit', UtilPath::getJSPath( 'goal/init' ), ['jquery'] );
    }

    public function loadCSS()
    {
	    wp_register_style( 'dinet_goal_css', plugin_dir_url( __FILE__ ) . '../../ressources/css/goal.css' );
	    wp_enqueue_style( 'dinet_goal_css' );
    }

    public function displayGoals( $userId = null )
    {
        $this->goal->getGoal()->setUserId(isset( $userId ) ? $userId : get_current_user_id() );

        $goals = $this->goal->getRepository()->getAll( $_GET['patient_id'] );

        $display['addGoal'] = true;

        include UtilPath::getViewsPath('goal/goal' );
    }

    public static function getUncheckIcon()
    {
	    return '<svg width="30" height="30" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1312 256h-832q-66 0-113 47t-47 113v832q0 66 47 113t113 47h832q66 0 113-47t47-113v-832q0-66-47-113t-113-47zm288 160v832q0 119-84.5 203.5t-203.5 84.5h-832q-119 0-203.5-84.5t-84.5-203.5v-832q0-119 84.5-203.5t203.5-84.5h832q119 0 203.5 84.5t84.5 203.5z"/></svg>';
    }

    public static function getCheckIcon()
    {
	    return '<svg width="30" height="30" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M813 1299l614-614q19-19 19-45t-19-45l-102-102q-19-19-45-19t-45 19l-467 467-211-211q-19-19-45-19t-45 19l-102 102q-19 19-19 45t19 45l358 358q19 19 45 19t45-19zm851-883v960q0 119-84.5 203.5t-203.5 84.5h-960q-119 0-203.5-84.5t-84.5-203.5v-960q0-119 84.5-203.5t203.5-84.5h960q119 0 203.5 84.5t84.5 203.5z" fill="#0085ba"/></svg>';
    }
}