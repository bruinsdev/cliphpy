<?php
use Cliphpy\Lib\Log;

class LogTest extends PHPUnit_Framework_TestCase
{

  /**
   * @covers Cliphpy\Lib\Log::setLogDir
   * @covers Cliphpy\Lib\Log::info
   * @covers Cliphpy\Lib\Log::error
   * @covers Cliphpy\Lib\Log::debug
   * @covers Cliphpy\Lib\Log::write
   * @covers Cliphpy\Lib\Log::writeLog
   * @covers Cliphpy\Lib\Log::__destruct
   */
  public function testCreateLogFiles(){
    $testObj = new Log;
    $logDir = __DIR__ . "/../../test/tmp";
    $testObj->setLogDir($logDir);

    $testObj->info("INFO MESSAGE");
    $testObj->error("ERROR MESSAGE");
    $testObj->debug("DEBUG MESSAGE");
    $testObj->write();

    $infoFilePath  = $logDir . "/info_" . date("Y-m-d") . ".log";
    $errorFilePath = $logDir . "/error_" . date("Y-m-d") . ".log";
    $debugFilePath = $logDir . "/debug_" . date("Y-m-d") . ".log";

    $this->assertFileExists($infoFilePath);
    $this->assertFileExists($errorFilePath);
    $this->assertFileExists($debugFilePath);

    $infoFileSize = filesize($infoFilePath);
    $errorFileSize = filesize($errorFilePath);
    $debugFileSize = filesize($debugFilePath);

    $this->assertEquals(41, $infoFileSize);
    $this->assertEquals(42, $errorFileSize);
    $this->assertEquals(42, $debugFileSize);

    $testObj->info("INFO MESSAGE 2");
    $testObj->error("ERROR MESSAGE 2");
    $testObj->debug("DEBUG MESSAGE 2");

    unset($testObj);

    $infoFileSize2 = filesize($infoFilePath);
    $errorFileSize2 = filesize($errorFilePath);
    $debugFileSize2 = filesize($debugFilePath);

    $this->assertEquals(84, $infoFileSize2);
    $this->assertEquals(86, $errorFileSize2);
    $this->assertEquals(86, $debugFileSize2);
  }
}