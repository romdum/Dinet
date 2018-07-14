<?php

namespace Dinet\Tests\Patient;

use Dinet\Patient\Patient;
use Dinet\Patient\PatientCtrl;
use Dinet\Patient\Weight;
use WP_UnitTestCase;

require_once '/var/www/html/Dinet/src/wp-content/plugins/dinet/app/main/utils/UtilPath.php';
require_once '/var/www/html/Dinet/src/wp-content/plugins/dinet/app/main/patient/controller/PatientCtrl.php';

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
        $userId = wp_create_user( 'withPatientTest', '' );
        $Patient = new Patient( $userId );
        $this->PatientCtrl->setPatient( $Patient );

        $this->assertEquals( $Patient, $this->PatientCtrl->getPatient() );
    }

    /**
     * @test
     */
    public function weightHistoryEmpty()
    {
        $userId = wp_create_user( 'weightHistoryEmptyTest', '' );
        $Patient = new Patient( $userId );
        $this->PatientCtrl->setPatient( $Patient );

        $this->assertEquals( [], $this->PatientCtrl->getWeightHistory()->getValues() );
    }

    /**
     * @test
     */
    public function weightHistorySimple()
    {
        $userId = wp_create_user( 'weightHistorySimpleTest', '' );
        $Patient = new Patient( $userId );
        $this->PatientCtrl->setPatient( $Patient );

        update_user_meta( $Patient->getUserId(), 'dinetWeight_1511378285', 55 );
        update_user_meta( $Patient->getUserId(), 'dinetWeight_1518178286', 56 );
        update_user_meta( $Patient->getUserId(), 'dinetWeight_1518378287', 57 );

        $weightHistory = $this->PatientCtrl->getWeightHistory()->getValues();

        $this->assertEquals( [
            [1518378287 => 57],
            [1518178286 => 56],
            [1511378285 => 55],
        ], [
            [$weightHistory[0]->getTimeStamp() => $weightHistory[0]->getValue()],
            [$weightHistory[1]->getTimeStamp() => $weightHistory[1]->getValue()],
            [$weightHistory[2]->getTimeStamp() => $weightHistory[2]->getValue()],
        ]);
    }

    /**
     * @test
     */
    public function weightHistoryComplex()
    {
        $this->markTestIncomplete( 'weightHistory with complex value not implements yet.' );
        // test with incorrect timestamp
        // test with empty time => meta_key = dinetWeight_
    }
}
