<?php

namespace Dinet\Tests\Patient;

use Dinet\Patient\Patient;
use Dinet\Patient\PatientCtrl;
use WP_UnitTestCase;

require_once '/var/www/html/Dinet/src/wp-content/plugins/dinet/app/main/utils/UtilPath.php';
require_once '/var/www/html/Dinet/src/wp-content/plugins/dinet/app/main/patient/PatientCtrl.php';

class PatientCtrlTest extends WP_UnitTestCase
{
    private $PatientCtrl;

    public function __construct( ?string $name = null, array $data = [], string $dataName = '' )
    {
        parent::__construct( $name, $data, $dataName );

        $this->PatientCtrl = new PatientCtrl();
    }

    /**
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

        $this->assertEquals( [], $this->PatientCtrl->getWeightHistory() );
    }

    /**
     * @test
     */
    public function weightHistorySimple()
    {
        $userId = wp_create_user( 'weightHistorySimpleTest', '' );
        $Patient = new Patient( $userId );
        $this->PatientCtrl->setPatient( $Patient );

        update_user_meta( $Patient->getUserId(), 'dinetWeight_1518378285', 55 );
        update_user_meta( $Patient->getUserId(), 'dinetWeight_1518378286', 56 );
        update_user_meta( $Patient->getUserId(), 'dinetWeight_1518378287', 57 );

        $metaKey = 'meta_key';
        $metaValue = 'meta_value';
        $this->assertEquals( [
            [$metaKey => '1518378287', $metaValue => '57'],
            [$metaKey => '1518378286', $metaValue => '56'],
            [$metaKey => '1518378285', $metaValue => '55']
        ], $this->PatientCtrl->getWeightHistory() );
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
