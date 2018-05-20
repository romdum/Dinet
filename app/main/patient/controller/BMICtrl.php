<?php

namespace Dinet\Patient;

use Dinet\UtilPath;

require_once UtilPath::getPatientPath( 'model/BMI' );

class BMICtrl
{
	/** @var BMI */
	private $bmi;

	/** @var float */
	private $height;

	/** @var float */
	private $weight;

	public function __construct( $height = 0, $weight = 0 )
	{
		$this->height = $height;
		$this->weight = $weight;
		$this->bmi = new BMI();
	}

	public function getBmi()
	{
		if( $this->bmi->getBmi() === null )
		{
			if( $this->height !== 0.0 && $this->weight !== 0.0 )
			{
				$this->bmi->setBmi(round($this->weight / ( $this->height * $this->height ) * 10 ) / 10 );
			}
			else
			{
				$this->bmi->setBmi( __( 'Merci de renseigner votre poids et votre taille' ) );
			}
		}
		return $this->bmi->getBmi();
	}

	public function getFontSize()
	{
		return is_numeric( $this->getBmi() ) ? '5rem' : '';
	}

	public function getColor()
	{
		if( $this->bmi->getColor() === null )
		{
			$this->loadBmiVar();
		}
		return $this->bmi->getColor();
	}

	public function getComment()
	{
		if( $this->bmi->getComment() === null )
		{
			$this->loadBmiVar();
		}
		return $this->bmi->getComment();
	}

	private function loadBmiVar()
	{
		$bmi = $this->getBmi();
		if ( $bmi < 18 )
		{
			$this->bmi->setComment( __( 'Maigreur' ) );
			$this->bmi->setColor( '#FFA515' );
		}
		elseif ( $bmi < 25 )
		{
			$this->bmi->setComment( __( 'Corpulence normale' ) );
			$this->bmi->setColor( '#40B514' );
		}
		elseif ( $bmi < 30 )
		{
			$this->bmi->setComment( __( 'Surpoids' ) );
			$this->bmi->setColor( '#FFA515' );
		}
		else
		{
			$this->bmi->setComment( __( 'Obésité' ) );
			$this->bmi->setColor( '#FF2D2D' );
		}
	}

	public function __toString()
	{
		return '' . $this->getBmi();
	}
}