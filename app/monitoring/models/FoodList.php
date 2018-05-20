<?php

namespace Dinet\Monitoring;

use Dinet\UtilPath;

require_once UtilPath::getMonitoringPath( 'models/Food' );

class FoodList
{
    /** @var array $list : Food array */
    private $list;

    public function getList(): array
    {
        return ( ! is_array( $this->list ) ) ? [] : $this->list;
    }

    public function setList( array $list ): void
    {
        $this->list = $list;
    }

    public function addFood( Food $food ): void
    {
        $this->list[] = $food;
    }
}