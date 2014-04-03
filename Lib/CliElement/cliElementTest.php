<?php
use
  Cliphpy\Lib\CliElement,
  Cliphpy\Lib\Log,
  Cliphpy\Prototypes\Configuration;

class testElement extends PHPUnit_Framework_TestCase
{

  /**
   * @covers \Cliphpy\Lib\Element::setConfig
   * @covers \Cliphpy\Lib\Element::getConfig
   */
  public function testConfig(){
    $testObj = new CliElement;
    $config = new Configuration;

    $testObj->setConfig($config);
    $this->assertEquals($config, $testObj->getConfig());
  }

  /**
   * @covers \Cliphpy\Lib\Element::setLog
   * @covers \Cliphpy\Lib\Element::getLog
   */
  public function testLog(){
    $testObj = new CliElement;
    $log = new Log;

    $testObj->setLog($log);
    $this->assertEquals($log, $testObj->getLog());
  }

  /**
   * @covers \Cliphpy\Lib\Element::setIdChild
   * @covers \Cliphpy\Lib\Element::getIdChild
   */
  public function testIdChild(){
    $testObj = new CliElement;
    $idChild = rand(100,10000);

    $testObj->setIdChild($idChild);
    $this->assertEquals($idChild, $testObj->getIdChild());
  }
}