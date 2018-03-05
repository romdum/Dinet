<?php

namespace Dinet\Patient;

use Dinet\Settings;

require_once plugin_dir_path( __FILE__ ) . '../Settings.php';

class PatientSettings extends Settings
{
    private $userId;

    public function __construct( $userId = null )
    {
        $this->userId = $userId === null ? get_current_user_id() : $userId;

        parent::__construct();
    }

    /**
     * Create default settings in the database, table options.
     *
     * @override
     */
    public function createDefaultOption()
    {
        if( $this->toString() === '' )
        {
            $defaultSettings = [
                'Monitoring' => [
                    'activate' => true,
                    'display'  => [
                        'chart' => true,
                        'bmi'   => true
                    ]
                ]
            ];

            $this->save( $defaultSettings );
        }
    }

    /**
     * @override
     */
    protected function toString()
    {
        $str = get_user_meta( $this->userId, self::NAME, true );
        return $str === false ? '' : $str;
    }

    /**
     * @param $value
     * @override
     */
    protected function save( $value )
    {
        $update = update_user_meta( $this->userId, self::NAME, json_encode( $value ) );

        if( $update )
        {
            $this->settings = json_decode( json_encode( $value ) );
        }
    }
}