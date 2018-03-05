<?php

namespace Dinet\Tests\Patient;

use Dinet\Patient\PatientCtrl;
use WP_UnitTestCase;

require_once '/var/www/html/Dinet/src/wp-content/plugins/dinet/app/main/utils/UtilPath.php';
require_once '/var/www/html/Dinet/src/wp-content/plugins/dinet/Dinet.php';
require_once '/var/www/html/Dinet/src/wp-content/plugins/dinet/app/main/patient/PatientCtrl.php';

class PatientLoaderTest extends WP_UnitTestCase
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
    public function loadWithoutPatient()
    {
        $this->PatientCtrl->load();
        $this->assertEquals( get_current_user_id(), $this->PatientCtrl->getPatient()->getUserId() );
        $this->assertEquals( wp_get_current_user()->first_name, $this->PatientCtrl->getPatient()->getFirstName() );
        $this->assertEquals( wp_get_current_user()->last_name, $this->PatientCtrl->getPatient()->getLastName() );
    }
}