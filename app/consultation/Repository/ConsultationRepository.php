<?php

namespace Dinet\Consultation\Repository;

use Dinet\Consultation\Model\Consultation;
use Dinet\Patient\Patient;
use Dinet\Patient\PatientCtrl;
use WP_Query;

class ConsultationRepository
{
    /**
     * @param int $patientId
     *
     * @return array
     */
    public function findByPatientId($patientId)
    {
        $wpq = new WP_Query([
            'post_type' => 'consultation',
            'meta_query' => [
                [
                    'key'     => 'dinet_consultation_patient_id',
                    'value'   => $patientId,
                    'compare' => '=',
                ],
            ],
        ]);
        $result = [];

        while ( $wpq->have_posts() )
        {
            $wpq->the_post();
            // TODO: créer complètement l'objet
            $result[] = (new Consultation())
                ->setId( get_the_ID() )
                ->setContent( get_the_content() )
                ->setDate( get_post_meta( get_the_ID(), 'dinet_consultation_start', true ) )
                ->setTitle( get_the_title())
                ->setType( '' )
                ->setPatient( new Patient() );
        }

        wp_reset_postdata();

        return $result;
    }
}