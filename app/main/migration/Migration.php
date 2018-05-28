<?php

namespace Dinet\Migration;

use Dinet\Dinet;
use Dinet\UtilPath;

require_once UtilPath::getMainPath( 'migration/MigrationInterface' );

/**
 * Class Migration
 *
 * Main class of migration package. All migrations classes have to extends this one. 
 *
 * @package Dinet\Migration
 */
class Migration implements MigrationInterface
{
    protected $dbVersion = 0;

    public function __construct()
    {
        $this->dbVersion = $this->getDbVersion();
    }

    protected function callMigrationClass( $version )
    {
        require_once UtilPath::getMainPath( 'migration/MigrationV' . $version );

        $className = '\Dinet\Migration\MigrationV' . $version;
        if( class_exists( $className ) )
        {
            $this->updateDbVersion( intval( $this->dbVersion ) + 1 );
            /** @var Migration $migration */
            $migration = new $className();
            $migration->migrate();
        }
    }

    protected function migrationClassExists( $version )
    {
        return file_exists( UtilPath::getMainPath( 'migration/MigrationV' . $version ) );
    }

    protected function needUpdate()
    {

        return intval( $this->dbVersion ) < intval( Dinet::DB_VERSION );
    }

    protected function updateDbVersion( $version )
    {
        update_option( 'dinet', $version );
        $this->dbVersion = $version;
    }

    protected function getDbVersion()
    {
        global $wpdb;
        return intval( $wpdb->get_var( "SELECT option_value FROM {$wpdb->options} WHERE option_name = 'dinet'" ) );
    }

    public function migrate()
    {
        if( $this->needUpdate() && $this->migrationClassExists( $this->dbVersion ) )
        {
            $this->callMigrationClass( $this->dbVersion );
        }
    }
}