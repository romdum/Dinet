<?php

namespace Dinet\Consultation\Controller;

use Dinet\Consultation\Model\Consultation;
use Dinet\Consultation\Repository\ConsultationRepository;

class ConsultationCtrl
{
    /** @var Consultation */
    private $consultation;

    /** @var ConsultationRepository */
    private $consultationRepository;

    public function __construct( Consultation $consultation = null )
    {
        $this->consultation = $consultation ?: new Consultation();
        $this->consultationRepository = new ConsultationRepository();
    }

    public function save( $post_id, $post )
    {
        if( $post->post_type !== 'consultation' )
        {
            if( isset( $_POST['start'] ) )
            {
                update_post_meta( $post_id, 'dinet_consultation_start', $_POST['start'] );
            }

            if( isset( $_POST['patient_id'] ) )
            {
                update_post_meta( $post_id, 'dinet_consultation_patient_id', $_POST['patient_id'] );
            }
        }
    }
}