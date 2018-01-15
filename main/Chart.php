<?php

namespace Dinet;

use DateTime;

abstract class Chart
{
    private $title;
    private $valueAttributes;
    private $dataType;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle( $title )
    {
        $this->title = htmlspecialchars( $title );
    }

    public function getXLabels()
    {
	    return [
		    'du '. firstDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 21 ) ) ) . ' au ' . lastDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 21 ) ) ),
		    'du '. firstDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 14 ) ) ) . ' au ' . lastDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 14 ) ) ),
		    'du '. firstDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 7 ) ) ) . ' au ' . lastDayOfWeek( new DateTime( date( 'Y-m-d', time() - 60 * 60 * 24 * 7 ) ) ),
		    'du '. firstDayOfWeek() . ' au ' . lastDayOfWeek()
	    ];
    }

    public function getDataType()
    {
        return $this->dataType;
    }

    public function getValueAttributes()
    {
        return $this->valueAttributes;
    }

    public function setValueAttributes( $value )
    {
        if( is_array( $value ) )
            $this->valueAttributes = $value;
    }

    public function display()
    {
	    include PLUGIN_PATH . "ressources/views/chart.php";
    }

    public abstract function getDataset();
}
