<?php

namespace Dinet\Tests\Patient;

use Dinet\Patient\Patient;
use Dinet\Patient\PatientCtrl;
use WP_UnitTestCase;

require_once __DIR__ . '/../../../app/main/utils/UtilPath.php';
require_once __DIR__ . '/../../../app/main/patient/controller/PatientCtrl.php';

class PatientCtrlTest extends WP_UnitTestCase
{
    private $PatientCtrl;

    public function __construct( ?string $name = null, array $data = [], string $dataName = '' )
    {
        parent::__construct( $name, $data, $dataName );

        $this->PatientCtrl = new PatientCtrl();
    }

    /**
     * Test Patient
     *
     * @test
     */
    public function withoutPatient()
    {
        $this->assertInstanceOf( '\Dinet\Patient\Patient', $this->PatientCtrl->getPatient() );
        $this->assertEquals( get_current_user_id(), $this->PatientCtrl->getPatient()->getUserId() );
    }

    /**
     * @test
     */
    public function withPatient()
    {
        $Patient = new Patient( 1 );
        $this->PatientCtrl->setPatient( $Patient );

        $this->assertEquals( $Patient, $this->PatientCtrl->getPatient() );
    }

    /**
     * @test
     */
    public function weightHistoryEmpty()
    {
        $Patient = new Patient( 1 );
        $this->PatientCtrl->setPatient( $Patient );

        $this->assertEquals( [], $this->PatientCtrl->getWeightHistory()->getValues() );
    }
}
