<?php

class Chart
{
    private $title;
    private $xLabels;
    private $valueAttributes;
    private $dataType;

    // dataType
    const FOOD_MONITORING = 1;
    const WEIGHT_HISTORY = 2;

    public function __construct( $dataType = 1 )
    {
        $this->dataType = $dataType;
    }

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
        return $this->xLabels;
    }

    public function setXLabels( $labels )
    {
        if( is_array( $labels ) )
        {
            $this->xLabels = $labels;
        }
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
        {
            $this->valueAttributes = $value;
        }
    }
}
