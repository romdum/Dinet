<?php

class BMIPatientController
{
    const ORANGE = "#FFA515", GREEN = "#40B514", RED = "#FF2D2D", FONT_SIZE = "5rem";
    const LOW_BMI = "Maigreur", GOOD_BMI = "Corpulence normale", HIGH_BMI = "Surpoids";
    const OBESITY = "Obésité", ERROR_BMI = "Merci de renseigner votre poids et votre taille";

    private $imc, $imc_color, $imc_font_size, $imc_comment;
    private $Patient;

    public function __construct( $Patient )
    {
        $this->Patient = $Patient;

        $this->calcul_imc();
        $this->load_imc_comment();
    }

    public function get_imc()
    {
        return $this->imc;
    }

    public function get_imc_color()
    {
        return $this->imc_color;
    }

    public function get_imc_font_size()
    {
        return $this->imc_font_size;
    }

    public function get_imc_comment()
    {
        return $this->imc_comment;
    }

    public function get_patient()
    {
        return $this->Patient;
    }

    public function calcul_imc()
    {
        if( $this->Patient->get_height() != 0 && $this->Patient->get_weight() != 0 )
        {
            $this->imc = round(
                $this->Patient->get_weight() / ( $this->Patient->get_height() * $this->Patient->get_height() ) * 10 ) / 10;
            $this->imc_font_size = self::FONT_SIZE;
        }
        else
        {
            $this->imc = self::ERROR_BMI;
        }
    }

    public function load_imc_comment()
    {
        if ( $this->imc < 18 )
        {
            $this->imc_comment = self::LOW_BMI;
            $this->imc_color = self::ORANGE;
        }
        elseif ( $this->imc < 25 )
        {
            $this->imc_comment = self::GOOD_BMI;
            $this->imc_color = self::GREEN;
        }
        elseif ( $this->imc < 30 )
        {
            $this->imc_comment = self::HIGH_BMI;
            $this->imc_color = self::ORANGE;
        }
        else
        {
            $this->imc_comment = self::OBESITY;
            $this->imc_color = self::RED;
        }
    }
}
