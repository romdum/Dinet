<?php

namespace Dinet\Patient;

class BMI
{
	/** @var string */
	private $color;

	/** @var string */
	private $fontSize;

	/** @var string */
	private $comment;

	/** @var string|float */
	private $bmi;

	/**
	 * @return string
	 */
	public function getColor(): ?string {
		return $this->color;
	}

	/**
	 * @param string $color
	 *
	 * @return BMI
	 */
	public function setColor( string $color ): BMI {
		$this->color = $color;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFontSize(): ?string {
		return $this->fontSize;
	}

	/**
	 * @param string $fontSize
	 *
	 * @return BMI
	 */
	public function setFontSize( string $fontSize ): BMI {
		$this->fontSize = $fontSize;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getComment(): ?string {
		return $this->comment;
	}

	/**
	 * @param string $comment
	 *
	 * @return BMI
	 */
	public function setComment( string $comment ): BMI {
		$this->comment = $comment;

		return $this;
	}

	/**
	 * @return float|string
	 */
	public function getBmi() {
		return $this->bmi;
	}

	/**
	 * @param float|string $bmi
	 *
	 * @return BMI
	 */
	public function setBmi( $bmi ) {
		$this->bmi = $bmi;

		return $this;
	}
}