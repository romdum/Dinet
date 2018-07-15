<?php

namespace Dinet\Tests;

use Dinet\Settings;
use Dinet\SettingsEnum;
use Dinet\Util;
use stdClass;
use \WP_UnitTestCase;

require_once __DIR__ . '/../../Dinet.php';
require_once __DIR__ . '/../../app/main/Settings.php';
require_once __DIR__ . '/../../app/main/SettingsEnum.php';
require_once __DIR__ . '/../../app/main/utils/Util.php';

class SettingsTest extends WP_UnitTestCase
{
	private $settings;

	public function __construct()
	{
		$this->settings = new Settings();
		$this->settings->createDefaultOption();

		parent::__construct();
	}

	/**
	 * Test default settings values.
	 *
	 * @covers Settings::getSetting
	 */
	public function createDefaultOption()
	{
        $settings = $this->settings->getSetting( SettingsEnum::MONITORING, SettingsEnum::ACTIVATE );
		$this->assertTrue( $settings,
			'Create default settings : FAILED');
	}

	/**
	 * Test if the JSON setting format is correct.
	 *
	 * @after
	 * @coversNothing
	 * @param string $testCode
	 */
	public function settingsFormat( $testCode = 'UNKNOW' )
	{
		$settings = get_option( Settings::NAME );
		$this->assertNotFalse( $settings,
			'Settings format incorrect after test ' . $testCode );
    }

	/**
	 * Test to get all settings.
	 *
	 * @covers Settings::getSettings
	 */
    public function getAllSettings()
    {
	    $this->assertTrue(
		    $this->settings->getSetting() ===
            get_option( Settings::NAME ),
		    'getSettings doesn\'t return all settings.' );
    }

	/**
	 * Test setSetting method (normal use)
	 *
	 * @covers Settings::setSetting
	 * @covers Settings::getSetting
	 */
    public function setSetting()
    {
	    $this->settings->setSetting( false, 'VehiclePostType', 'display', 'photo' );
	    $this->assertFalse( $this->settings->getSetting( 'VehiclePostType', 'display', 'photo' ),
		    'setSetting test failed: {"VehiclePostType":{"display":{"photo":true}}} (should be false)');
	    $this->settingsFormat( 'SET001' );
    }

	/**
	 * Test setSetting method to create a new setting
	 *
	 * @covers Settings::setSetting
	 * @covers Settings::getSetting
	 */
    public function createSetting()
    {
	    $this->settings->setSetting( 'Hello', 'test', 'tes', 'te' );
	    $this->assertTrue( $this->settings->getSetting( 'test', 'tes', 'te' ) === 'Hello',
		    'setSetting recursively test failed.');
	    $this->settingsFormat( 'SET002' );
    }

	/**
	 * Test getSetting method with incorrect parameter
	 *
	 * @covers Settings::getSetting
	 * @dataProvider SettingsTest::failDataProvider
	 */
    public function incorrectGetSetting()
    {
    	$failSettings = self::failDataProvider();

		foreach( $failSettings as $message => $setting )
        {
            $this->assertNull( $this->settings->getSetting( $setting ), $message );
        }
    }

	/**
	 * Test setSetting method with incorrect parameter
	 *
	 * @covers Settings::setSetting
	 * @covers Settings::getSetting
	 */
    public function incorrectSetSetting()
    {
	    $correctSettings = get_option( Settings::NAME );
	    $failSettings = self::failDataProvider();

	    foreach( $failSettings as $message => $setting )
	    {
	        $this->settings->setSetting( 'Hello', $setting );
	        $this->assertTrue($this->settings->getSetting() === $correctSettings, $message );
	    }
    }

	public static function failDataProvider()
	{
		return [
			'Fail with stdClass'         => new stdClass(),
			'Fail with empty array'      => [],
			'Fail with boolean'          => true,
			'Fail with null'             => null,
			'Fail with numeric'          => 0,
			'Fail with array of strings' => ['You','shall','not','pass','...','tests']
		];
	}
}