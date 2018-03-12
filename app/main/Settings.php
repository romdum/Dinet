<?php

namespace Dinet;

/**
 * Class to manage settings (located in options table).
 */
class Settings
{
    /**
     * Settings like they're saved in database (serialized string).
     * @var string
     */
    protected $settings;

    /**
     * Option name (options.option_name)
     */
    const NAME = 'dinet_settings';

    /**
     * Settings constructor.
     */
    public function __construct()
    {
        $this->settings = get_option( $this->getOptionName(), null );

        if( ! isset( $this->settings ) )
        {
            $this->createDefaultOption();
        }
    }

    /**
     * Return the setting, null if setting not exists, all settings if no parameter given.
     *
     * @example getSetting( 'setting1', 'setting1.1', 'setting1.1.1')
     * @param array[string] ...$names
     *
     * @return string|array|null
     */
    public function getSetting( ...$names )
    {
        $result = $this->settings;
        for( $i = 0; $i < count( $names ); $i++ )
        {
            if( is_string( $names[$i] ) && isset( $result[$names[$i]] ) )
            {
                $result = $result[$names[$i]];
            }
            else
            {
                return null;
            }
        }

        return $result;
    }

    /**
     * Change a setting value and save it in database.
     *
     * @param $value
     * @param array[string] ...$names
     */
    public function setSetting( $value, ...$names )
    {
        if( ! isset( $names ) || ! is_array( $names ) || empty( $names ) )
        {
            return;
        }

        $settings = $this->settings;

        $cmdToExe = '$settings';
        for( $i = 0; $i < count( $names ); $i++ )
        {
            if( is_string( $names[$i] ) )
            {
                $cmdToExe .= '[$names[' . $i . ']]';
            }
            else
            {
                return;
            }
        }
        $cmdToExe .= ' = $value;';

        eval( $cmdToExe );

        $this->save( $settings );
    }

    /**
     * Create default settings in the database, table options.
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
                ],
                'Consultation' => [
                    'activate' => true
                ]
            ];

            $this->save( $defaultSettings );
        }
    }

    protected function save( $value )
    {
        if( update_option( $this->getOptionName(), $value ) )
        {
            $this->settings = $value;
        }
    }

    protected function getOptionName()
    {
        return self::NAME;
    }
}
