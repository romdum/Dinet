<?php

namespace Dinet\Patient;

class Patient
{
    private $userId;
    private $firstName, $lastName;
    private $weight, $height;
    private $phone;
    private $observation;

    public function __construct( $userId = null )
    {
        $this->userId = $userId === null ? get_current_user_id() : $userId;
    }

    public function getUserId(): int
    {
        return isset( $this->userId ) ? $this->userId : 0;
    }

    public function getFirstName(): string
    {
        return isset( $this->firstName ) ? $this->firstName : '';
    }

    public function getLastName(): string
    {
        return isset( $this->lastName ) ? $this->lastName : '';
    }

    public function getWeight(): float
    {
        return floatval( $this->weight );
    }

    public function getHeight(): float
    {
        return floatval( $this->height );
    }

    public function getLogin(): string
    {
        return get_userdata( $this->userId )->user_login;
    }

    public function getRegisteredDate()
    {
        return get_userdata( $this->userId )->user_registered;
    }

    public function getObservation(): string
    {
        return isset( $this->observation ) ? $this->observation : '';
    }

    public function getPhone(): string
    {
	    return isset( $this->phone ) ? $this->phone : '';
    }

	public function setFirstName( string $firstName ): Patient
	{
		$this->firstName = $firstName;
		return $this;
	}

	public function setLastName( string $lastName ): Patient
	{
		$this->lastName = $lastName;
		return $this;
	}

	public function setWeight( float $weight ): Patient
	{
		$this->weight = $weight;
		return $this;
	}

	public function setHeight( float $height ): Patient
	{
		$this->height = $height;
		return $this;
	}

	public function setPhone( string $phone ): Patient
	{
		$this->phone = $phone;
		return $this;
	}

	public function setObservation( string $observation ): Patient
	{
		$this->observation = $observation;
		return $this;
	}
}
