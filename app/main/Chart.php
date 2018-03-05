<?php

namespace Dinet;

abstract class Chart
{
    private $title;
    private $valueAttributes;
    private $dataType;

    public abstract function getDataset();
    public abstract function getXLabels();

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle( $title )
    {
        $this->title = htmlspecialchars( $title );
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

    public function display()
    {
	    include UtilPath::getViewsPath( 'chart' );
    }
}
