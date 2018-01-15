<?php

namespace Dinet\Patient;

class Patient
{
    private $user_id;
    private $first_name, $last_name;
    private $weight, $height;
    private $phone;

    public function __construct( $user_id = null )
    {
        $user_id == null ? $this->user_id = get_current_user_id() : $this->user_id = $user_id;
    }

    public function get_user_id(): int
    {
        return $this->user_id;
    }

    public function get_first_name()
    {
	    if( ! isset( $this->first_name ) )
		    $this->first_name = get_metadata( "user", $this->user_id, "first_name", true );

        return $this->first_name;
    }

    public function get_last_name()
    {
    	if( ! isset( $this->last_name ) )
		    $this->last_name = get_metadata( "user", $this->user_id, "last_name", true );

        return $this->last_name;
    }

    public function get_weight()
    {
    	if( ! isset( $this->weight ) )
		    $this->weight = get_metadata( "user", $this->user_id, "dinet_poids", true );

        return ! empty( $this->weight ) ? floatval( $this->weight ) : 0;
    }

    public function get_weight_history()
    {
        return get_metadata( 'user', $this->user_id, 'dinet_poids' );
    }

    public function get_height()
    {
    	if( ! isset( $this->height ) )
		    $this->height = get_metadata( "user", $this->user_id, "dinet_taille", true );

        return ! empty( $this->height ) ? floatval( $this->height ) : 0;
    }

    public function get_login()
    {
        return get_userdata( $this->user_id )->user_login;
    }

    public function get_registered_date()
    {
        return get_userdata( $this->user_id )->user_registered;
    }

    public function get_observation()
    {
        return get_metadata( "user", $this->user_id, "dinet_observation", true );
    }

    public function get_phone()
    {
    	if( ! isset( $this->phone ) )
		    $this->phone = get_metadata( "user", $this->user_id, "dinet_phone", true );

	    return $this->phone;
    }
}
