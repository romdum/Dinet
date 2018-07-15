<?php

namespace Dinet\Tests\Patient;

use Dinet\Patient\Patient;
use Dinet\Patient\Weight;
use WP_UnitTestCase;

require_once __DIR__ . '/../../../app/main/patient/model/Patient.php';

class PatientTest extends WP_UnitTestCase
{
    const USERNAME = 'testUser';

    private $Patient;

    public function __construct( ?string $name = null, array $data = [], string $dataName = '' )
    {
        parent::__construct( $name, $data, $dataName );

        $this->Patient = new Patient( 1 );
    }

    /**
     * Test to get patient first name when it's not given.
     *
     * @test
     */
    public function firstNameEmpty()
    {
        $this->assertEmpty( $this->Patient->getFirstName() );
    }

    /**
     * Test to get patient first name.
     *
     * @test
     */
    public function firstNameGiven()
    {
        $firstName = 'firstName';
        $this->Patient->setFirstName( $firstName );
        $this->assertEquals( $firstName, $this->Patient->getFirstName() );
    }

    /**
     * @test
     */
    public function lastNameEmpty()
    {
        $this->assertEmpty( $this->Patient->getLastName() );
    }

    /**
     * Test to get patient last name.
     *
     * @test
     */
    public function lastNameGiven()
    {
        $firstName = 'lastName';
        $this->Patient->setLastName( $firstName );
        $this->assertEquals( $firstName, $this->Patient->getLastName() );
    }

    /**
     * @expectedException \TypeError
     * @test
     */
    public function weightEmpty()
    {
        $this->Patient->getWeight();
    }

    /**
     * @test
     */
    public function weightGiven()
    {
        $weight = 55.5;
        $tstamp = 1518178286;
        $this->Patient->setWeight( (new Weight())->setValue($weight)->setTimestamp($tstamp) );
        $this->assertEquals( $weight, $this->Patient->getWeight()->getValue() );
        $this->assertEquals( $tstamp, $this->Patient->getWeight()->getTimestamp() );
    }

    /**
     * @expectedException \TypeError
     * @test
     */
    public function weightString()
    {
        $weight = 'TOTO';
        $this->Patient->setWeight( $weight );
    }

    /**
     * @test
     */
    public function heightEmpty()
    {
        $this->assertEmpty( $this->Patient->getHeight() );
    }

    /**
     * @test
     */
    public function heightGiven()
    {
        $height = 1.74;
        $this->Patient->setHeight( $height );
        $this->assertEquals( $height, $this->Patient->getHeight() );
    }

    /**
     * @test
     */
    public function phoneEmpty()
    {
        $this->assertEmpty( $this->Patient->getPhone() );
    }

    /**
     * @test
     */
    public function phoneGiven()
    {
        $phone = '0123456789';
        $this->Patient->setPhone( $phone );
        $this->assertEquals( $phone, $this->Patient->getPhone() );
    }

    /**
     * @test
     */
    public function observationEmpty()
    {
        $this->assertEmpty( $this->Patient->getObservation() );
    }

    /**
     * @test
     */
    public function observationGiven()
    {
        $observation = 'I am an observation.';
        $this->Patient->setObservation( $observation );
        $this->assertEquals( $observation, $this->Patient->getObservation() );
    }
}
