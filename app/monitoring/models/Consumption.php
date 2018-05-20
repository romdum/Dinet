<?php

namespace Dinet\Monitoring;

use Dinet\Patient\Patient;

class Consumption
{
    /** @var int $id */
    private $id;

    /** @var Patient $Patient */
    private $Patient;

    /** @var Food $Food */
    private $Food;

    /** @var float $quantity */
    private $quantity;

    /** @var string $date */
    private $date;

    /** @var int $hungryLevel */
    private $hungryLevel;

    /** @var string */
    private $feelingBefore, $feelingAfter;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId( int $id ): Consumption
    {
        $this->id = $id;
        return $this;
    }

    public function getPatient(): Patient
    {
        return $this->Patient;
    }

    public function setPatient( Patient $Patient ): Consumption
    {
        $this->Patient = $Patient;
        return $this;
    }

    public function getFood(): Food
    {
        return $this->Food;
    }

    public function setFood( Food $Food ): Consumption
    {
        $this->Food = $Food;
        return $this;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity( float $quantity ): Consumption
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate( string $date ): Consumption
    {
        $this->date = $date;
        return $this;
    }

    public function getHungryLevel(): int
    {
        return $this->hungryLevel;
    }

    public function setHungryLevel( int $hungryLevel ): Consumption
    {
        $this->hungryLevel = $hungryLevel;
        return $this;
    }

    public function getFeelingBefore(): string
    {
        return $this->feelingBefore;
    }

    public function setFeelingBefore( string $feelingBefore ): Consumption
    {
        $this->feelingBefore = $feelingBefore;
        return $this;
    }

    public function getFeelingAfter(): string
    {
        return $this->feelingAfter;
    }

    public function setFeelingAfter( string $feelingAfter ): Consumption
    {
        $this->feelingAfter = $feelingAfter;
        return $this;
    }
}