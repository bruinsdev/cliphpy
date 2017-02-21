<?php

namespace Test\Cliphpy\Element;

use Cliphpy\CAO\Redis;
use Cliphpy\DAO\MongoDb;
use Cliphpy\DAO\Postgresql;
use Cliphpy\Prototype\Configuration;
use PHPUnit\Framework\TestCase;
use Cliphpy\Element\Element;
use Cliphpy\Log\Log;

class ElementTest extends TestCase
{
    public function testSetConfig()
    {
        $testObj = new ElementExt();
        $config = new Configuration();
        $testObj->setConfig($config);
        $this->assertEquals($config, $testObj->getConfig());
    }

  /**
   * @expectedException \Exception
   */
  public function testSetAliasOne()
  {
      $testObj = new ElementExt();
      $alias = rand(1, 20000);
      $testObj->setAlias($alias);
  }

    public function testSetAliasTwo()
    {
        $testObj = new ElementExt();
        $alias = 'testingAlias';
        $testObj->setAlias($alias);
        $this->assertEquals($alias, $testObj->getAlias());
    }

    public function testLog()
    {
        $testObj = new ElementExt();
        $log = new Log();

        $testObj->setLog($log);
        $this->assertEquals($log, $testObj->getLog());
    }

    public function testSetPostgre()
    {
        $testObj = new ElementExt();
        $postgresql = new Postgresql();
        $testObj->setPostgresql($postgresql);
    }

    public function testSetRedis()
    {
        $testObj = new ElementExt();
        $redis = new Redis();
        $testObj->setRedis($redis);
    }

    public function testSetMongo()
    {
        $testObj = new ElementExt();
        $mongo = new MongoDb();
        $testObj->setMongoDb($mongo);
    }

    public function testGetSumId()
    {
        $testObj = new ElementExt();
        $obj = new \stdClass();
        $obj->firstAttr = 'asd';
        $obj->secondAttr = 123;
        $this->assertEquals(205587684, $testObj->getSumId($obj));
    }

  /**
   * @expectedException \Exception
   */
  public function testIdChildOne()
  {
      $testObj = new ElementExt();
      $testObj->setIdChild('abc');
  }

    public function testIdChildTwo()
    {
        $testObj = new ElementExt();
        $idChild = rand(1000, 1000000);
        $testObj->setIdChild($idChild);
        $this->assertEquals($idChild, $testObj->getIdChild());
    }
}

class ElementExt extends Element
{
    public function close($signal)
    {
    }
}
