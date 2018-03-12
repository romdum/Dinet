<?php

namespace Dinet\Goal;

class Goal
{
    /** @var int : unique identifier */
    private $id;

    /** @var : deadline to achieve goal */
    private $date;

    /** @var string : goal description */
    private $description;

    /** @var boolean : true if goal is achieved */
    private $done;

    /** @var int : user id */
    private $userId;

    public function setDescription( string $description )
    {
        $this->description = $description;

        return $this;
    }

    public function setDate( $date ): Goal
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDone( bool $done ): Goal
    {
        $this->done = $done;

        return $this;
    }

    public function isDone(): bool
    {
        return $this->done;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId( int $id ): Goal
    {
        $this->id = $id;

        return $this;
    }

    public function setUserId( int $userId ): Goal
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}