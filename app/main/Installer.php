<?php

namespace Dinet;

require_once plugin_dir_path( __FILE__ ) . '../../Dinet.php';

class Installer
{
    const NAME = 'Installer';

    /**
     * Plugin installation
     */
    public static function install()
    {
        /*
         * Add table: customer, food
         */
        self::createFoodUsersTable();
        self::createFoodTable();

        /*
         * Add parameter dinet in options table to know if the plugin is installed
         */
        update_option( 'dinet', Dinet::DB_VERSION );
    }

    private static function createFoodUsersTable()
    {
        $GLOBALS["wpdb"]->query(
            "CREATE TABLE IF NOT EXISTS `" . Dinet::$TABLE_FOOD_USER . "` (
    			`id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `user_id` BIGINT(20) UNSIGNED NOT NULL,
                `food_id` INT(10) UNSIGNED NOT NULL,
                `quantity` INT(5) UNSIGNED NOT NULL,
                `eat_date` DATETIME,
                `hungry_level` VARCHAR(100) DEFAULT '0',
                `feeling_before` VARCHAR(100),
                `feeling_after` VARCHAR(100)
            );" );
    }

    private static function createFoodTable()
    {
        $GLOBALS["wpdb"]->query(
            "CREATE TABLE IF NOT EXISTS `" . Dinet::$TABLE_FOOD . "` (
			  `id` INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
              `group` VARCHAR(60) DEFAULT NULL,
              `designation` VARCHAR(255) DEFAULT NULL, 
              `energy` DOUBLE(8,2) DEFAULT NULL,          -- kcal / 100g
              `water` DOUBLE(8,2) DEFAULT NULL,           -- g / 100g
              `protein` DOUBLE(8,2) DEFAULT NULL,         -- g / 100g
              `glucid` DOUBLE(8,2) DEFAULT NULL,          -- g / 100g
              `lipid` DOUBLE(8,2) DEFAULT NULL,           -- g / 100g
              `sugar` DOUBLE(8,2) DEFAULT NULL,           -- g / 100g
              `amidon` DOUBLE(8,2) DEFAULT NULL,          -- g / 100g
              `fiber` DOUBLE(8,2) DEFAULT NULL,           -- g / 100g
              `saturedAG` DOUBLE(8,2) DEFAULT NULL,       -- g / 100g
              `monounsaturedAG` DOUBLE(8,2) DEFAULT NULL, -- g / 100g
              `polyunsaturedAG` DOUBLE(8,2) DEFAULT NULL, -- g / 100g
              `omega9` DOUBLE(8,2) DEFAULT NULL,          -- g / 100g
              `omega8` DOUBLE(8,2) DEFAULT NULL,          -- g / 100g
              `omega3` DOUBLE(8,2) DEFAULT NULL,          -- g / 100g
              `epa` DOUBLE(8,2) DEFAULT NULL,             -- g / 100g
              `dha` DOUBLE(8,2) DEFAULT NULL,             -- g / 100g
              `cholesterol` DOUBLE(8,2) DEFAULT NULL,     -- mg / 100g
              `salt` DOUBLE(8,2) DEFAULT NULL,            -- g / 100g
              `calcium` DOUBLE(8,2) DEFAULT NULL,         -- mg / 100g
              `cuivre` DOUBLE(8,2) DEFAULT NULL,          -- mg / 100g
              `iron` DOUBLE(8,2) DEFAULT NULL,            -- mg / 100g
              `magnesium` DOUBLE(8,2) DEFAULT NULL,       -- mg / 100g
              `phosphore` DOUBLE(8,2) DEFAULT NULL,       -- mg / 100g
              `potassium` DOUBLE(8,2) DEFAULT NULL,       -- mg / 100g
              `sodium` DOUBLE(8,2) DEFAULT NULL,          -- mg / 100g
              `zinc` DOUBLE(8,2) DEFAULT NULL,            -- mg / 100g
              `retinol` DOUBLE(8,2) DEFAULT NULL,         -- µg / 100g
              `betaCarotene` DOUBLE(8,2) DEFAULT NULL,    -- µg / 100g
              `vitaminD` DOUBLE(8,2) DEFAULT NULL,        -- µg / 100g
              `vitaminE` DOUBLE(8,2) DEFAULT NULL,        -- mg / 100g
              `vitaminK1` DOUBLE(8,2) DEFAULT NULL,       -- µg / 100g
              `vitaminK2` DOUBLE(8,2) DEFAULT NULL,       -- µg / 100g
              `vitaminC` DOUBLE(8,2) DEFAULT NULL,        -- mg / 100g
              `vitaminB1` DOUBLE(8,2) DEFAULT NULL,       -- mg / 100g
              `vitaminB2` DOUBLE(8,2) DEFAULT NULL,       -- mg / 100g
              `vitaminB3` DOUBLE(8,2) DEFAULT NULL,       -- mg / 100g
              `vitaminB5` DOUBLE(8,2) DEFAULT NULL,       -- mg / 100g
              `vitaminB6` DOUBLE(8,2) DEFAULT NULL,       -- mg / 100g
              `vitaminB9` DOUBLE(8,2) DEFAULT NULL,       -- µg / 100g
              `vitaminB12` DOUBLE(8,2) DEFAULT NULL       -- µg / 100g
            );" );
    }

    /**
     * Function called when the plugin is activate
     */
    public static function activate()
    {
        if ( ! self::isInstalled() )
        {
            self::install();
        }
    }

    /**
     * Function called when the plugin is deactivate
     */
    public static function deactivate()
    {

    }

    /**
     * Uninstall plugin
     */
    public static function uninstall()
    {
        global $wpdb;

        $wpdb->query( "DROP TABLE `" . Dinet::$TABLE_FOOD . "`, `" . Dinet::$TABLE_FOOD_USER . "`" );

        $wpdb->delete(
            $wpdb->options,
            array( 'option_name' => Dinet::SLUG )
        );
    }

    /**
     * Return true if the plugin is already installed
     * @return boolean
     */
    public static function isInstalled()
    {
        return $GLOBALS['wpdb']->get_var( "SELECT COUNT(1) FROM {$GLOBALS['wpdb']->options} WHERE option_name = 'dinet'" ) > 0;
    }
}
