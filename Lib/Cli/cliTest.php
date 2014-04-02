<?php
use
  Cliphpy\Lib\Cli,
  Cliphpy\Prototypes\Configuration;

class CliTest extends PHPUnit_Framework_TestCase
{

  /**
   * @covers Cliphpy\Lib\Cli::setName
   * @covers Cliphpy\Lib\Cli::getName
   */
  public function testSetName(){
    $testObj = new Cli;
    $name = " CLI name testing ";
    $expected = "CLI_name_testing";
    $testObj->setName($name);

    $this->assertEquals($expected, $testObj->getName());
  }
}