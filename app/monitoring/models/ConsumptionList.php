<?php

namespace Dinet\Monitoring;

use Dinet\UtilPath;

require_once UtilPath::getMonitoringPath( 'models/Consumption' );

class ConsumptionList
{
    /** @var array $list : Consumption array */
    private $list = [];

    public function getList(): array
    {
        return $this->list;
    }

    public function setList( array $list ): void
    {
        $this->list = $list;
    }

    public function addConsumption( Consumption $consumption ): void
    {
        $this->list[] = $consumption;
    }
}