<?php

class Food
{
    private $id;
    private $designation;
    private $groupe;
    private $energy, $water, $protein, $glucid, $lipid, $sugar, $amidon, $fiber, $saturedAG, $polyunsaturedAG, $monounsaturedAG, $omega3, $omega6, $omega9, $epa, $dha, $cholesterol, $salt, $calcium, $cuivre, $iron, $magnesium, $phosphore, $potassium, $sodium, $zinc, $retinol, $betaCarotene;
    private $vitaminD, $vitaminE, $vitaminK1, $vitaminK2, $vitaminC, $vitaminB1, $vitaminB2, $vitaminB3, $vitaminB5, $vitaminB6, $vitaminB9, $vitaminB12;  

    public function __construct( $id = null, $designation = null, $groupe = null )
    {
        if( $id !== null )
        {
            $this->id = $id;
            $this->designation = $designation;
            $this->groupe = $groupe;
        }
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_designation()
    {
        return $this->designation;
    }

    public function get_groupe()
    {
        return $this->groupe;
    }
}
