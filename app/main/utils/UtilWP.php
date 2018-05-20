<?php

namespace Dinet;

class UtilWP
{
    const NONCE_PREFIX = 'nonce';

    public static function loadJS( string $slug, string $path, array $dependencies = [], array $var = [] )
    {
        $var = array_merge( $var, [
            'ajaxURL' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( self::NONCE_PREFIX . ucfirst( $slug ) )
        ]);
        wp_register_script( $slug, $path, $dependencies );
        wp_localize_script( $slug, 'util' . ucfirst( $slug ), $var );
        wp_enqueue_script( $slug );
    }

    public static function getNonceName( string $slug )
    {
        return self::NONCE_PREFIX . ucfirst( $slug );
    }
}