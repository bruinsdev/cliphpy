<?php
namespace Cliphpy\Lib;
use Cliphpy\Prototypes\Configuration;

class CliTest extends \PHPUnit_Framework_TestCase
{
  public function testClose(){
    $testObj = new Cli;
    $testObj->close(1);
  }

  public function testSetName(){
    $testObj  = new Cli;
    $name     = " CLI name testing ";
    $expected = "CLI_name_testing";
    $testObj->setName($name);
    $this->assertEquals($expected, $testObj->getName());
  }

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
      "short" => "c:t:q::v",
      "long"  => array(
        "child:",
        "test:",
        "quit::",
        "verbose",
      ),
    );
    $this->assertEquals($expected, $actual);
  }

  public function testUsage(){
    $testObj     = new Cli;
    $usage       = $testObj->getUsage();
    $this->assertTrue(is_string($usage));
    $customUsage = "This is custom usage, only for testing";
    $testObj->setUsage($customUsage);
    $expected    = $usage. "Custom usage:" . PHP_EOL . PHP_EOL;
    $expected   .= $customUsage . PHP_EOL;
    $actual      = $testObj->getUsage();
    $this->assertEquals($expected, $actual);
  }
}
