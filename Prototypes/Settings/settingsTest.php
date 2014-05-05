<?php
use Cliphpy\Prototypes\Settings;

class testSettings extends PHPUnit_Framework_TestCase
{
  /**
   * @use \Cliphpy\Prototypes\Settings::__construct
   */
  public function testConstruct(){
    $testObj = new cloneSettings;

    $logDirExpected = __DIR__ . "/../log";
    $pidDirExpected = __DIR__ . "/../pid";

    $this->assertEquals($logDirExpected, $testObj->logDir);
    $this->assertEquals($pidDirExpected, $testObj->pidDir);
  }

}

class cloneSettings extends Settings{}