<?php

namespace Dinet;

/**
 * Class to manage settings (located in options table).
 */
class Settings
{
    /**
     * Settings like they're saved in database (JSON string).
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
        $this->settings = json_decode( $this->toString() );

        if( empty( $this->settings ) )
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
        $tmpSettings = Util::object_to_array( $this->settings );

        $result = $tmpSettings;
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

        $settings = Util::object_to_array( json_decode( $this->toString() ) );

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
        if( get_option( Settings::NAME, null ) === null )
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

    protected function toString()
    {
        return get_option( self::NAME );
    }

    protected function save( $value )
    {
        if( update_option( self::NAME, json_encode( $value ) ) )
        {
            $this->settings = json_decode( json_encode( $value ) );
        }
    }
}
