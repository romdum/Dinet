<?php

namespace Dinet;

class Util
{
    public static function session_start()
    {
        if( ! session_id() )
        {
            \session_start();
        }
    }   
    
    public static function array_to_object( array $arr )
    {
        return is_array( $arr ) ? ( object ) array_map(__METHOD__, $arr) : $arr;
    }
    
    public static function object_to_array( $obj )
    {
        if ( is_object( $obj ) )
        {
            $obj = get_object_vars( $obj );
        }
        return is_array( $obj ) ? array_map( __METHOD__, $obj ) : $obj;
    }
}
