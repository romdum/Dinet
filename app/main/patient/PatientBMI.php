<?php

namespace Dinet\Patient;

/**
 * Trait PatientBMI use in PatientCtrl class.
 *
 * @package Dinet\Patient
 * @property Patient Patient
 */
trait PatientBMI
{
    private $ORANGE = "#FFA515", $GREEN = "#40B514", $RED = "#FF2D2D", $FONT_SIZE = "5rem";

    private $imc, $imc_color, $imc_font_size, $imc_comment;

    public function getImc()
    {
        return $this->imc;
    }

    public function getImcColor()
    {
        return $this->imc_color;
    }

    public function getImcFontSize()
    {
        return $this->imc_font_size;
    }

    public function getImcComment()
    {
        return $this->imc_comment;
    }

    public function calcBMI()
    {
        if( $this->Patient->getHeight() != 0 && $this->Patient->getWeight() != 0 )
        {
            $this->imc = round(
                 $this->Patient->getWeight() / ( $this->Patient->getHeight() * $this->Patient->getHeight() ) * 10 ) / 10;
            $this->imc_font_size = $this->FONT_SIZE;
        }
        else
        {
            $this->imc = __( "Merci de renseigner votre poids et votre taille" );
        }
    }

    public function loadImcComment()
    {
        $lowBMI  = __( "Maigreur" );
        $goodBMI = __( "Corpulence normale" );
        $highBMI = __( "Surpoids" );
        $obesity = __( "Obésité" );

        if ( $this->imc < 18 )
        {
            $this->imc_comment = $lowBMI;
            $this->imc_color = $this->ORANGE;
        }
        elseif ( $this->imc < 25 )
        {
            $this->imc_comment = $goodBMI;
            $this->imc_color = $this->GREEN;
        }
        elseif ( $this->imc < 30 )
        {
            $this->imc_comment = $highBMI;
            $this->imc_color = $this->ORANGE;
        }
        else
        {
            $this->imc_comment = $obesity;
            $this->imc_color = $this->RED;
        }
    }
}
