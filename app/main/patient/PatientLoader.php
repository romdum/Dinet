<?php

namespace Dinet\Patient;

use Dinet\Dinet;
use Dinet\UtilPath;

require_once UtilPath::getPatientPath( 'PatientSettings' );

/**
 * Trait PatientLoader use in PatientCtrl class.
 *
 * @package Dinet\Patient
 * @property Patient Patient
 */
trait PatientLoader
{
    private $AUTO_LOAD = [
        'Height',
        'Observation',
        'Phone'
    ];

    public function load() : void
    {
        $this->autoLoad();

        global $wpdb;
        $sql = "
            SELECT meta_value 
            FROM {$wpdb->usermeta} 
            WHERE meta_key LIKE 'dinetWeight%' 
            AND user_id = %d 
            ORDER BY meta_key DESC 
            LIMIT 1;
        ";
        $weight = $wpdb->get_var( $wpdb->prepare( $sql, $this->Patient->getUserId() ) );

        $this->Patient
            ->setWeight( floatval( ! empty( $weight ) ? floatval( $weight ) : 0 ) )
            ->setFirstName( get_metadata( 'user', $this->Patient->getUserId(), 'first_name', true ) )
            ->setLastName( get_metadata( 'user', $this->Patient->getUserId(), 'last_name', true ) );

        $this->settings = new PatientSettings( $this->Patient->getUserId() );
    }

    private function autoLoad()
    {
        $metadata = get_metadata( 'user', $this->Patient->getUserId() );

        foreach( $this->AUTO_LOAD as $method )
        {
            $metadataId = Dinet::SLUG . $method;
            $method     = 'set' . $method;

            if( isset( $metadata[$metadataId] ) && method_exists( $this->Patient, $method ) )
            {
                $this->Patient->{$method}( $metadata[$metadataId][0] );
            }
        }
    }
}