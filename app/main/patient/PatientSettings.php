<?php

namespace Dinet\Patient;

use Dinet\Settings;

require_once plugin_dir_path( __FILE__ ) . '../Settings.php';

class PatientSettings extends Settings
{
    const NAME = 'dinet_user_settings_';

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
        if( get_option( $this->getOptionName(), null ) === null )
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
     * @return string
     */
    protected function getOptionName()
    {
        return self::NAME . $this->userId;
    }
}