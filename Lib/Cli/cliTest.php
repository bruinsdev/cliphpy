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

  /**
   * @covers Cliphpy\Lib\Cli::setOptions
   * @covers Cliphpy\Lib\Cli::getOptions
   */
  public function testSetOptions(){
    $testObj = new Cli;
    $options = array(
      "t:"  => "test:",
      "q::" => "quit::",
      "v"   => "verbose",
    );
    $testObj->setOptions($options);

    $actual = $testObj->getOptions();
    $expected = array(
      "short" => "t:q::v",
      "long" => array(
        "child:",
        "test:",
        "quit::",
        "verbose",
      ),
    );

    $this->assertEquals($expected, $actual);
  }

  /**
   * @covers Cliphpy\Lib\Cli::getUsage
   */
  public function testUsage(){
    $testObj = new Cli;
    $usage = $testObj->getUsage();
    $this->assertTrue(is_string($usage));
  }
}