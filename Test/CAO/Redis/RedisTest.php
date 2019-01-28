<?php

namespace Test\Cliphpy\CAO;

use Cliphpy\CAO\Redis;
use Cliphpy\Prototype\Configuration;
use PHPUnit\Framework\TestCase;

class RedisTest extends TestCase
{
    /**
     * @var Redis
     */
    private $redis;

    public function testConnect()
    {
        $alias = 'redis';
        $this->redis = new Redis();
        $this->redis->setAlias($alias);
        $config = new Configuration();
        $config->{$alias} = new Redis\Configuration();

        $this->assertEquals($config->{$alias}->address, '127.0.0.1');
        $this->assertEquals($config->{$alias}->port, 6379);
        $this->assertEquals($config->{$alias}->idDatabase, 0);

        $config->{$alias}->address = '127.0.0.1';
        $config->{$alias}->port = 6379;
        $config->{$alias}->idDatabase = 15;

        $config->{$alias}->address = 'redis';

        $this->redis->setConfig($config);
        $this->redis->connect();
    }

    public function testIsConnected()
    {
        $this->testConnect();
        $isConnected = $this->redis->isConnected();

        $this->assertTrue($isConnected);
    }

    public function testDisconnect()
    {
        $this->testConnect();
        $this->redis->disconnect();
        $isConnected = $this->redis->isConnected();
        $this->assertFalse($isConnected);
    }

    public function testFlushAll()
    {
        $this->testConnect();
        $isFlushed = $this->redis->flushAll();
        $this->assertTrue($isFlushed);
    }

    public function testCountUsage()
    {
        $this->testConnect();
        $this->redis->FlushAll();
        $this->redis->set('_TEST_', 1);
        $this->redis->set('_TEST_', 2);
        $this->redis->set('_TEST_', 3);
        $this->redis->set('_TEST_', 4);
        $this->redis->set('_TEST_', 5);
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

    public function testGet()
    {
        $this->testConnect();
        $value = $this->redis->get('_PHP_UNIT_TEST_KEY_');

        $this->assertNull($value);
    }

    public function testSet()
    {
        $this->testConnect();
        $saved = '_PHP_UNIT_TEST_VALUE_';
        $key1 = 'PHPUnit';
        $key2 = 'TestKey';
        $value = $this->redis->get($key1, $key2);
        if (is_null($value)) {
            $this->redis->set($saved);
        }

        $value2 = $this->redis->get($key1, $key2);
        $this->assertEquals($saved, $value2);
        $this->redis->flushAll();
    }

    /**
     * @expectedException \Exception
     */
    public function testGetVersionOne()
    {
        $redis = new Redis();
        $redis->getVersion();
    }

    public function testGetVersionTwo()
    {
        $this->testConnect();
        $this->redis->getVersion();
    }
}
