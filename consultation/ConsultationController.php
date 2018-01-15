<?php

namespace Dinet\Consultation;

class ConsultationController
{
    function hasConsultation( $patient_id )
    {
        global $wpdb;
        $result = get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = 'dinet_consultation_patient_id' AND meta_value = '$patient_id'", ARRAY_N);
        return count( $result ) > 0;
    }
}
