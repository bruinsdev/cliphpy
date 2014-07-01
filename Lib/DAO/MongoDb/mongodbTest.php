<?php
namespace Cliphpy\Lib\DAO;

class testMongoDb extends \PHPUnit_Framework_TestCase
{
  /**
   * @expectedException Exception
   */
  public function testConnectOne(){
    $testObj = new MongoDb;
    $testObj->getVersion();
  }

  public function testConnectTwo(){
    $testObj = new MongoDb;
    $config = new \Cliphpy\Prototypes\Configuration;
    $config->mongo = new MongoDb\Configuration;
    $testObj->setConfig($config);
    $testObj->connect();
    $testObj->setAlias($config->mongo->database);
    $database = $testObj->getDatabase();
    $this->assertInstanceOf("MongoDb", $database);
    $version = $testObj->getVersion();
    $this->assertTrue(is_string($version));
    $testObj->close(1);
  }
}