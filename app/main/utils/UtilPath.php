<?php

namespace Dinet;

/**
 * Class UtilPath
 *
 * This class is use to include files.
 * Always put a slash at the end of a return.
 *
 * @package Dinet
 */
class UtilPath
{
    const TYPE_URL  = 'url';
    const TYPE_PATH = 'path';

    private static function buildPath( string $path, string $file, string $ext, string $type )
    {
        if( substr( $path, -1 ) !== '/' && $path !== '' )
        {
            $path .= '/';
        }

        $ext = $file === '' ? '' : '.' . $ext;
        $type = $type === self::TYPE_PATH ? plugin_dir_path( __FILE__ ) : plugin_dir_url( __FILE__ );

        return $type . $path . $file . $ext;
    }

    public static function getAppPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH ): string
    {
        return self::buildPath( '../../', $file, $ext, $type );
    }

    public static function getConsultationPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH ): string
    {
        return self::buildPath( '../../consultation/', $file, $ext, $type );
    }

    public static function getMainPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH ): string
    {
        return self::buildPath( '../', $file, $ext, $type );
    }

    public static function getPatientPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH ): string
    {
        return self::buildPath( '../patient/', $file, $ext, $type );
    }

    public static function getUtilsPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH ): string
    {
        return self::buildPath( '', $file, $ext, $type );
    }

    public static function getMonitoringPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH )
    {
        return self::buildPath( '../../monitoring/', $file, $ext, $type );
    }

    public static function getMonitoringCtrlPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH )
    {
        return self::buildPath( '../../monitoring/controllers/', $file, $ext, $type );
    }

    public static function getMonitoringModelsPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH )
    {
        return self::buildPath( '../../monitoring/models/', $file, $ext, $type );
    }

    public static function getRessourcesPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH )
    {
        return self::buildPath( '../../../ressources/', $file, $ext, $type );
    }

    public static function getJSPath( string $file = '', string $ext = 'js', string $type = self::TYPE_URL )
    {
        return self::buildPath( '../../../ressources/js/', $file, $ext, $type );
    }

    public static function getTemplatesPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH )
    {
        return self::buildPath( '../../../ressources/templates/', $file, $ext, $type );
    }

    public static function getViewsPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH )
    {
        return self::buildPath( '../../../ressources/views/', $file, $ext, $type );
    }

    public static function getPluginPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH )
    {
        return self::buildPath( '../../../', $file, $ext, $type );
    }

    public static function getGoalPath( string $file = '', string $ext = 'php', string $type = self::TYPE_PATH )
    {
        return self::buildPath( '../../goal/', $file, $ext, $type );
    }
}