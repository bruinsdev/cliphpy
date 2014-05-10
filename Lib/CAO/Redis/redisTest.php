<?php
namespace Cliphpy\Lib\CAO;
use Cliphpy\Prototypes\Configuration;

class testRedis extends \PHPUnit_Framework_TestCase
{


  /**
   * @var Redis
   */
  private $redis;

  /**
   * @covers Cliphpy\Lib\CAO\Redis\Configuration
   * @covers Cliphpy\Lib\CAO\Redis::connect
   */
  public function testConnect(){
    $alias = "redis";
    $this->redis = new Redis;
    $this->redis->setAlias($alias);
    $config = new Configuration;
    $config->{$alias} = new Redis\Configuration;

    $this->assertEquals($config->{$alias}->address, "127.0.0.1");
    $this->assertEquals($config->{$alias}->port, 6379);
    $this->assertEquals($config->{$alias}->idDatabase, 0);

    $config->{$alias}->address = "127.0.0.1";
    $config->{$alias}->port = 6379;
    $config->{$alias}->idDatabase = 15;

    $this->redis->setConfig($config);
    $this->redis->connect();
  }

  /**
   * @covers Cliphpy\Lib\CAO\Redis::isConnected
   */
  public function testIsConnected(){
    $this->testConnect();
    $isConnected = $this->redis->isConnected();

    $this->assertTrue($isConnected);
  }

  /**
   * @covers Cliphpy\Lib\CAO\Redis::disconnect
   * @covers Cliphpy\Lib\CAO\Redis::isConnected
   */
  public function testDisconnect(){
    $this->testConnect();
    $this->redis->disconnect();
    $isConnected = $this->redis->isConnected();
    $this->assertFalse($isConnected);
  }

  /**
   * @covers Cliphpy\Lib\CAO\Redis::flushAll
   */
  public function testFlushAll(){
    $this->testConnect();
    $isFlushed = $this->redis->flushAll();
    $this->assertTrue($isFlushed);
  }

  /**
   * @covers Cliphpy\Lib\CAO\Redis::getUsage
   * @covers Cliphpy\Lib\CAO\Redis::flushAll
   */
  public function testCountUsage(){
    $this->testConnect();
    $this->redis->FlushAll();
    $this->redis->set("_TEST_", 1);
    $this->redis->set("_TEST_", 2);
    $this->redis->set("_TEST_", 3);
    $this->redis->set("_TEST_", 4);
    $this->redis->set("_TEST_", 5);
    $usage = $this->redis->getUsage();
    $this->assertEquals($usage, 0);

    $this->redis->get(1);
    $this->redis->get(1);
    $this->redis->get(1);
    $this->redis->get(1);
    $this->redis->get(1);
    $this->redis->get(1);
    $this->redis->get(1);
    $usage = $this->redis->getUsage();
    $this->assertEquals($usage, 40);

    $this->redis->flushAll();
    $usage = $this->redis->getUsage();
    $this->assertEquals($usage, 0);
  }

  /**
   * @covers Cliphpy\Lib\CAO\Redis::get
   * @covers Cliphpy\Lib\CAO\Redis::caller
   * @covers Cliphpy\Lib\CAO\Redis::generateKey
   */
  public function testGet(){
    $this->testConnect();
    $value = $this->redis->get("_PHP_UNIT_TEST_KEY_");

    $this->assertNull($value);
  }

  /**
   * @covers Cliphpy\Lib\CAO\Redis::set
   * @covers Cliphpy\Lib\CAO\Redis::get
   * @covers Cliphpy\Lib\CAO\Redis::caller
   * @covers Cliphpy\Lib\CAO\Redis::generateKey
   * @covers Cliphpy\Lib\CAO\Redis::flushAll
   */
  public function testSet(){
    $this->testConnect();
    $saved = "_PHP_UNIT_TEST_VALUE_";
    $key1 = "PHPUnit";
    $key2 = "TestKey";
    $value = $this->redis->get($key1, $key2);
    if (is_null($value)){
      $this->redis->set($saved);
    }

    $value2 = $this->redis->get($key1, $key2);
    $this->assertEquals($saved, $value2);
    $this->redis->flushAll();
  }
}