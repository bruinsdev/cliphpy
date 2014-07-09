<?php
namespace Cliphpy\Lib;
use Cliphpy\Prototypes\Configuration;

class ProcessTest extends \PHPUnit_Framework_TestCase
{
  public function testClose(){
    $testObj = new Process;
    $testObj->close(1);
  }

  public function testInitPostgresql(){
    $testObj = new Process;
    $config = new Configuration;
    $testObj->setConfig($config);
    $alias = "postgre2323";
    $testObj->initPostgresql($alias);
    $this->assertInstanceOf("\Cliphpy\Lib\DAO\Postgresql", $testObj->{$alias});
  }

  public function testInitRedis(){
    $testObj = new Process;
    $config = new Configuration;
    $testObj->setConfig($config);
    $alias = "redis1212";
    $testObj->initRedis($alias);
    $this->assertInstanceOf("\Cliphpy\Lib\CAO\Redis", $testObj->{$alias});
  }

  public function testInitMongoDb(){
    $testObj = new Process;
    $config = new Configuration;
    $testObj->setConfig($config);
    $alias = "mongo3434";
    $testObj->initMOngoDb($alias);
    $this->assertInstanceOf("\Cliphpy\Lib\DAO\MongoDb", $testObj->{$alias});
  }

  /**
   * @expectedException Exception
   */
  public function testOptionsOne(){
    $testObj = new Process;
    $options = rand(1,20000);
    $testObj->setOptions($options);
  }

  public function testOptionsTwo(){
    $testObj = new Process;
    $options = array(
      "attr1" => true,
      "attr2" => array(1, 3, 8),
      "attr3" => "awsome",
      );
    $testObj->setOptions($options);
    $this->assertEquals($options, $testObj->getOptions());
  }
}