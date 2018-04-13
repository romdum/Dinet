<?php

namespace Dinet\Patient;


class Weight
{
	/** @var float */
	private $value;

	/** @var int */
	private $timestamp;

	/**
	 * @return float
	 */
	public function getValue(): float
	{
		return $this->value;
	}

	/**
	 * @param float $value
	 *
	 * @return Weight
	 */
	public function setValue( float $value ): Weight
	{
		$this->value = $value;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getTimestamp(): int
	{
		return $this->timestamp;
	}

	/**
	 * @param int $timestamp
	 *
	 * @return Weight
	 */
	public function setTimestamp( int $timestamp ): Weight
	{
		$this->timestamp = $timestamp;

		return $this;
	}

	public function __toString()
	{
		return strval( $this->getValue() );
	}
}
