<?php

namespace Dinet\Patient;

use Dinet\Chart;
use Dinet\UtilDate;

require_once plugin_dir_path( __FILE__ ) . '../Chart.php';

class WeightHistoryChart extends Chart
{
    const NUMBER_OF_DATA = 10;

    /** @var PatientCtrl */
    private $PatientCtrl;

    public function getPatientCtrl()
    {
        return isset( $this->PatientCtrl ) ? $this->PatientCtrl : new PatientCtrl();
    }

    public function setPatientCtrl( PatientCtrl $PatientCtrl )
    {
        $this->PatientCtrl = $PatientCtrl;
    }

    public function getDataset() : array
    {
        $dataset = [];

        $d = $this->getPatientCtrl()->getWeightHistory()->getValues( self::NUMBER_OF_DATA );

        foreach( $this->getValueAttributes() as $label => $color )
        {
            $data = [];

            /** @var Weight $item */
	        foreach( array_reverse( $d ) as $item )
            {
                array_push( $data, $item->getValue() );
            }

            array_push( $dataset, [
                "label"       => $label,
                "borderColor" => $color,
                "data"        => $data,
            ] );
        }

        return $dataset;
    }

    /**
     * @override
     *
     * @return array
     */
    public function getXLabels() : array
    {
        $dates = $this->PatientCtrl->getWeightHistory()->getValues( self::NUMBER_OF_DATA );
        $dates = array_reverse( $dates );
        $result = [];

        /** @var Weight $date */
	    foreach ( $dates as $date )
        {
            $result[] = date( UtilDate::DATE_FORMAT_FR, $date->getTimestamp() );
        }

        return $result;
    }

    public function getValueAttributes()
    {
        return [
            'Poids' => 'rgba(80 , 227, 28 , 1)'
        ];
    }
}
