<?php

class Patient
{
    private $user_id;
    private $first_name, $last_name;
    private $weight, $height;
    private $phone;

    public function __construct( $user_id = null )
    {
        $user_id == null ? $this->user_id = get_current_user_id() : $this->user_id = $user_id;
        $this->loadFirstName();
        $this->loadLastName();
        $this->loadHeight();
        $this->loadWeight();
        $this->loadPhone();
    }

    public function get_user_id()
    {
        return $this->user_id;
    }

    public function get_first_name()
    {
        return $this->first_name;
    }

    public function get_last_name()
    {
        return $this->last_name;
    }

    public function get_weight()
    {
        return $this->weight;
    }

    public function get_weight_history()
    {
        return get_metadata( 'user', $this->user_id, 'dinet_poids' );
    }

    public function get_height()
    {
        return $this->height;
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
        if( ! empty( get_metadata( "user", $this->user_id, "dinet_observation", true ) ) )
        {
            return get_metadata( "user", $this->user_id, "dinet_observation", true );
        }
        else
        {
            return "";
        }
    }

    public function get_phone()
    {
        return $this->phone;
    }

    public function loadFirstName()
    {
        if( ! empty( get_metadata( "user", $this->user_id, "first_name", true ) ) )
        {
            $this->first_name = get_metadata( "user", $this->user_id, "first_name", true );
        }
    }

    public function loadLastName()
    {
        if( ! empty( get_metadata( "user", $this->user_id, "last_name", true ) ) )
        {
            $this->last_name = get_metadata( "user", $this->user_id, "last_name", true );
        }
    }

    public function loadWeight()
    {
        if( ! empty( get_metadata( "user", $this->user_id, "dinet_poids", true ) ) )
        {
            $this->weight = get_metadata( "user", $this->user_id, "dinet_poids", true );
        }
        else
        {
            $this->weight = 0;
        }
    }


    public function loadHeight()
    {
        if( ! empty( get_metadata( "user", $this->user_id, "dinet_taille", true ) ) )
        {
            $this->height = get_metadata( "user", $this->user_id, "dinet_taille", true );
        }
        else
        {
            $this->height = 0;
        }
    }

    public function loadPhone()
    {
        if( ! empty( get_metadata( "user", $this->user_id, "dinet_phone", true ) ) )
        {
            $this->phone = get_metadata( "user", $this->user_id, "dinet_phone", true );
        }
        else
        {
            $this->phone = '';
        }
    }
}
