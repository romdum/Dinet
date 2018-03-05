<?php

namespace Dinet\Patient;

use Dinet\Dinet;

/**
 * Trait PatientSaver use in PatientCtrl class.
 *
 * @package Dinet\Patient
 * @property Patient Patient
 */
trait PatientSaver
{
    private $AUTO_SAVE = [
        'Observation',
        'Phone'
    ];

    public function save( array $args = [] )
    {
        $this->autoSave( $args );

        $this->saveSimpleUserMeta( 'first_name', $args, 'FirstName' );
        $this->saveSimpleUserMeta( 'last_name', $args, 'LastName' );
        $this->saveSimpleUserMeta( 'dinetWeight_' . time(), $args, 'Weight' );

        $this->saveHeight( $args );
    }

    private function autoSave( array $args = [] ): void
    {
        foreach( $this->AUTO_SAVE as $method )
        {
            if( method_exists( $this->Patient, 'set' . $method ) && isset( $args[$method]) )
            {
                $this->Patient->{'set' . $method}( $args[$method], true );
                update_user_meta( $this->Patient->getUserId(), Dinet::SLUG . $method, htmlspecialchars( $args[$method] ) );
            }
        }
    }

    private function saveHeight( $args )
    {
        if( isset( $args['Height'] ) )
        {
            $heightArg = 'Height';
            $args[$heightArg] = floatval( str_replace( ",", ".", $args[$heightArg] ) );
            if ( $args[$heightArg] > 3 )
            {
                $args[$heightArg] = $args[$heightArg] / 100;
            }
            update_user_meta( $this->Patient->getUserId(), Dinet::SLUG . $heightArg, $args[$heightArg] );
        }
    }

    private function saveSimpleUserMeta( string $metaKey, $args, $index )
    {
        if( isset( $args[$index] ) )
        {
            update_user_meta( $this->Patient->getUserId(), $metaKey, htmlspecialchars( $args[$index] ) );
        }
    }
}