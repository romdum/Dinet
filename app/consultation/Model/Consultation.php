<?php

namespace Dinet\Consultation\Model;

use Dinet\Patient\Patient;

class Consultation
{
    /** @var integer */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $type;

    /** @var string */
    private $date;

    /** @var string */
    private $content;

    /** @var Patient */
    private $patient;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title ?: '';
    }

    /**
     * @param string $title
     *
     * @return Consultation
     */
    public function setTitle( string $title ): Consultation
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type ?: '';
    }

    /**
     * @param string $type
     *
     * @return Consultation
     */
    public function setType( string $type ): Consultation
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date ?: '';
    }

    /**
     * @param string $date
     *
     * @return Consultation
     */
    public function setDate( string $date ): Consultation
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content ?: '';
    }

    /**
     * @param string $content
     *
     * @return Consultation
     */
    public function setContent( string $content ): Consultation
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Patient
     */
    public function getPatient(): Patient
    {
        return $this->patient;
    }

    /**
     * @param Patient $patient
     *
     * @return Consultation
     */
    public function setPatient( Patient $patient ): Consultation
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Consultation
     */
    public function setId( $id ): Consultation
    {
        $this->id = $id;

        return $this;
    }
}