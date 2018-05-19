<?php

namespace Dinet\Goal;

use Dinet\UtilPath;
use TypeError;

class GoalCtrl
{
    /** @var Goal */
    private $goal;

    /** @var GoalRepository */
    private $repository;

    private function setGoalFromArray( array $data )
    {
        $this->goal = ( new Goal() )
            ->setDate( $data['goalDate'] )
            ->setDone( $data['goalDone'] )
            ->setDescription( $data['goalDescription'] )
            ->setUserId( (int) $data['goalUserId'] );

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
        check_ajax_referer( 'nonceNewGoal','nonce' );

        $this->setGoalFromArray( array_map( function( $elem ){ return htmlspecialchars( $elem ); }, $_POST ) );

        $this->goal->setId( $this->getRepository()->add( $this->goal ) );
		$goal = $this->goal;
        ob_start();
        include UtilPath::getViewsPath( 'goal/goalItemList' );
        $html = ob_get_clean();

        echo json_encode([
        	'html' => $html
        ]);
        wp_die();
    }

    public function getGoal(): Goal
    {
        if( ! isset( $this->goal ) )
        {
            $this->goal = new Goal();
        }

        return $this->goal;
    }

    public function setDoneRequest()
    {
	    check_ajax_referer( 'nonceSetGoalDone','nonce' );

	    $this->goal = $this->getRepository()->findById( $_POST['goalId'] );
	    $this->goal->setDone( ! $this->goal->isDone() );

	    $this->getRepository()->update( $this->goal );

		echo json_encode([
			'isDone' => $this->goal->isDone(),
			'icon'   => $this->goal->isDone() ? UI::getCheckIcon() : UI::getUncheckIcon()
		]);

	    wp_die();
    }

	/**
	 * @return GoalRepository
	 */
	public function getRepository(): ?GoalRepository
	{
		if( ! isset( $this->repository ) )
		{
			$this->repository = new GoalRepository();
		}

		return $this->repository;
	}
}