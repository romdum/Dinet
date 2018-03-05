<?php

namespace Dinet\Monitoring;

class Food
{
    /** @var string */
    public $id;

    /** @var string */
    public $designation;

    /** @var string */
    public $group;

    /** @var float */
    public $energy, $water, $protein, $glucid, $lipid, $sugar, $amidon, $fiber, $saturedAG, $polyunsaturedAG,
        $monounsaturedAG, $omega3, $omega6, $omega9, $epa, $dha, $cholesterol, $salt, $calcium, $cuivre, $iron,
        $magnesium, $phosphore, $potassium, $sodium, $zinc, $retinol, $betaCarotene,
        $vitaminD, $vitaminE, $vitaminK1, $vitaminK2, $vitaminC, $vitaminB1, $vitaminB2, $vitaminB3,
        $vitaminB5, $vitaminB6, $vitaminB9, $vitaminB12;


    public function __construct( string $id )
    {
        $this->id = $id;
    }

    public function getId() : string
    {
        return $this->id;
    }

    public function getDesignation() : string
    {
        return is_string( $this->designation ) ? $this->designation : '';
    }

    public function setDesignation( string $designation ): void
    {
        $this->designation = $designation;
    }

    public function getGroup() : string
    {
        return is_string( $this->group ) ? $this->group : '';
    }

    public function setGroup( string $group ): void
    {
        $this->group = $group;
    }

    public function getEnergy() : float
    {
        return is_float( $this->energy ) ? $this->energy : 0;
    }

    public function setEnergy( float $energy ): void
    {
        $this->energy = $energy;
    }

    public function getWater(): float
    {
        return is_float( $this->water ) ? $this->water : 0;
    }

    public function setWater( float $water ): void
    {
        $this->water = $water;
    }

    public function getProtein(): float
    {
        return is_float( $this->protein ) ? $this->protein : 0;
    }

    public function setProtein( float $protein ) : void
    {
        $this->protein = $protein;
    }

    public function getGlucid(): float
    {
        return is_float( $this->glucid ) ? $this->glucid : 0;
    }

    public function setGlucid( float $glucid ): void
    {
        $this->glucid = $glucid;
    }

    public function getLipid(): float
    {
        return is_float( $this->lipid ) ? $this->lipid : 0;
    }

    public function setLipid( float $lipid ): void
    {
        $this->lipid = $lipid;
    }

    public function getSugar(): float
    {
        return is_float( $this->sugar ) ? $this->sugar : 0;
    }

    public function setSugar( float $sugar ): void
    {
        $this->sugar = $sugar;
    }

    public function getAmidon(): float
    {
        return is_float( $this->amidon ) ? $this->amidon : 0;
    }

    public function setAmidon( float $amidon ): void
    {
        $this->amidon = $amidon;
    }

    public function getFiber(): float
    {
        return is_float( $this->fiber ) ? $this->fiber : 0;
    }

    public function setFiber( float $fiber ): void
    {
        $this->fiber = $fiber;
    }

    public function getSaturedAG(): float
    {
        return is_float( $this->saturedAG ) ? $this->saturedAG : 0;
    }

    public function setSaturedAG( float $saturedAG ): void
    {
        $this->saturedAG = $saturedAG;
    }

    public function getPolyunsaturedAG(): float
    {
        return is_float( $this->polyunsaturedAG ) ? $this->polyunsaturedAG : 0;
    }

    public function setPolyunsaturedAG( float $polyunsaturedAG ): void
    {
        $this->polyunsaturedAG = $polyunsaturedAG;
    }

    public function getMonounsaturedAG(): float
    {
        return is_float( $this->monounsaturedAG ) ? $this->monounsaturedAG : 0;
    }

    public function setMonounsaturedAG( float $monounsaturedAG ): void
    {
        $this->monounsaturedAG = $monounsaturedAG;
    }

    public function getOmega3(): float
    {
        return is_float( $this->omega3 ) ? $this->omega3 : 0;
    }

    public function setOmega3( float $omega3 ): void
    {
        $this->omega3 = $omega3;
    }

    public function getOmega6(): float
    {
        return is_float( $this->omega6 ) ? $this->omega6 : 0;
    }

    public function setOmega6( float $omega6 ): void
    {
        $this->omega6 = $omega6;
    }

    public function getOmega9(): float
    {
        return is_float( $this->omega9 ) ? $this->omega9 : 0;
    }

    public function setOmega9( float $omega9 ): void
    {
        $this->omega9 = $omega9;
    }

    public function getEpa(): float
    {
        return is_float( $this->epa ) ? $this->epa : 0;
    }

    public function setEpa( float $epa ): void
    {
        $this->epa = $epa;
    }

    public function getDha(): float
    {
        return is_float( $this->dha ) ? $this->dha : 0;
    }

    public function setDha( float $dha ): void
    {
        $this->dha = $dha;
    }

    public function getCholesterol(): float
    {
        return is_float( $this->cholesterol ) ? $this->cholesterol : 0;
    }

    public function setCholesterol( float $cholesterol ): void
    {
        $this->cholesterol = $cholesterol;
    }

    public function getSalt(): float
    {
        return is_float( $this->salt ) ? $this->salt : 0;
    }

    public function setSalt( float $salt ): void
    {
        $this->salt = $salt;
    }

    public function getCalcium(): float
    {
        return is_float( $this->calcium ) ? $this->calcium : 0;
    }

    public function setCalcium( float $calcium ): void
    {
        $this->calcium = $calcium;
    }

    public function getCuivre(): float
    {
        return is_float( $this->cuivre ) ? $this->cuivre : 0;
    }

    public function setCuivre( float $cuivre ): void
    {
        $this->cuivre = $cuivre;
    }

    public function getIron(): float
    {
        return is_float( $this->iron ) ? $this->iron : 0;
    }

    public function setIron( float $iron ): void
    {
        $this->iron = $iron;
    }

    public function getMagnesium(): float
    {
        return is_float( $this->magnesium ) ? $this->magnesium : 0;
    }

    public function setMagnesium( float $magnesium ): void
    {
        $this->magnesium = $magnesium;
    }

    public function getPhosphore(): float
    {
        return is_float( $this->phosphore ) ? $this->phosphore : 0;
    }

    public function setPhosphore( float $phosphore ): void
    {
        $this->phosphore = $phosphore;
    }

    public function getPotassium(): float
    {
        return is_float( $this->potassium ) ? $this->potassium : 0;
    }

    public function setPotassium( float $potassium ): void
    {
        $this->potassium = $potassium;
    }

    public function getSodium(): float
    {
        return is_float( $this->sodium ) ? $this->sodium : 0;
    }

    public function setSodium( float $sodium ): void
    {
        $this->sodium = $sodium;
    }

    public function getZinc(): float
    {
        return is_float( $this->zinc ) ? $this->zinc : 0;
    }

    public function setZinc( float $zinc ): void
    {
        $this->zinc = $zinc;
    }

    public function getRetinol(): float
    {
        return is_float( $this->retinol ) ? $this->retinol : 0;
    }

    public function setRetinol( float $retinol ): void
    {
        $this->retinol = $retinol;
    }

    public function getBetaCarotene(): float
    {
        return is_float( $this->betaCarotene ) ? $this->betaCarotene : 0;
    }

    public function setBetaCarotene( float $betaCarotene ): void
    {
        $this->betaCarotene = $betaCarotene;
    }

    public function getVitaminD(): float
    {
        return is_float( $this->vitaminD ) ? $this->vitaminD : 0;
    }

    public function setVitaminD( float $vitaminD ): void
    {
        $this->vitaminD = $vitaminD;
    }

    public function getVitaminE(): float
    {
        return is_float( $this->vitaminE ) ? $this->vitaminE : 0;
    }

    public function setVitaminE( float $vitaminE ): void
    {
        $this->vitaminE = $vitaminE;
    }

    public function getVitaminK1(): float
    {
        return is_float( $this->vitaminK1 ) ? $this->vitaminK1 : 0;
    }

    public function setVitaminK1( float $vitaminK1 ): void
    {
        $this->vitaminK1 = $vitaminK1;
    }

    public function getVitaminK2(): float
    {
        return is_float( $this->vitaminK2 ) ? $this->vitaminK2 : 0;
    }

    public function setVitaminK2( float $vitaminK2 ): void
    {
        $this->vitaminK2 = $vitaminK2;
    }

    public function getVitaminC(): float
    {
        return is_float( $this->vitaminC ) ? $this->vitaminC : 0;
    }

    public function setVitaminC( float $vitaminC ): void
    {
        $this->vitaminC = $vitaminC;
    }

    public function getVitaminB1(): float
    {
        return is_float( $this->vitaminB1 ) ? $this->vitaminB1 : 0;
    }

    public function setVitaminB1( float $vitaminB1 ): void
    {
        $this->vitaminB1 = $vitaminB1;
    }

    public function getVitaminB2(): float
    {
        return is_float( $this->vitaminB2 ) ? $this->vitaminB2 : 0;
    }

    public function setVitaminB2( float $vitaminB2 ): void
    {
        $this->vitaminB2 = $vitaminB2;
    }

    public function getVitaminB3(): float
    {
        return is_float( $this->vitaminB3 ) ? $this->vitaminB3 : 0;
    }

    public function setVitaminB3( float $vitaminB3 ): void
    {
        $this->vitaminB3 = $vitaminB3;
    }

    public function getVitaminB5(): float
    {
        return is_float( $this->vitaminB5 ) ? $this->vitaminB5 : 0;
    }

    public function setVitaminB5( float $vitaminB5 ): void
    {
        $this->vitaminB5 = $vitaminB5;
    }

    public function getVitaminB6(): float
    {
        return is_float( $this->vitaminB6 ) ? $this->vitaminB6 : 0;
    }

    public function setVitaminB6( float $vitaminB6 ): void
    {
        $this->vitaminB6 = $vitaminB6;
    }

    public function getVitaminB9(): float
    {
        return is_float( $this->vitaminB9 ) ? $this->vitaminB9 : 0;
    }

    public function setVitaminB9( float $vitaminB9 ): void
    {
        $this->vitaminB9 = $vitaminB9;
    }

    public function getVitaminB12(): float
    {
        return is_float( $this->vitaminB12 ) ? $this->vitaminB12 : 0;
    }

    public function setVitaminB12( float $vitaminB12 ): void
    {
        $this->vitaminB12 = $vitaminB12;
    }

}
