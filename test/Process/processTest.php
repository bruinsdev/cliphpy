<?php

namespace Test\Cliphpy\Process;

use Cliphpy\Prototype\Configuration;
use PHPUnit\Framework\TestCase;
use Cliphpy\Process\Process;
use Cliphpy\Exception\Exception;
use Cliphpy\DAO\Postgresql;
use Cliphpy\CAO\Redis;
use Cliphpy\DAO\MongoDb;

class ProcessTest extends TestCase
{
    public function testClose()
    {
        $testObj = new Process();
        $testObj->close(1);
    }

    public function testInitPostgresql()
    {
        $testObj = new Process();
        $config = new Configuration();
        $testObj->setConfig($config);
        $alias = 'postgre2323';
        $testObj->initPostgresql($alias);
        $this->assertInstanceOf(Postgresql::class, $testObj->{$alias});
    }

    public function testInitRedis()
    {
        $testObj = new Process();
        $config = new Configuration();
        $testObj->setConfig($config);
        $alias = 'redis1212';
        $testObj->initRedis($alias);
        $this->assertInstanceOf(Redis::class, $testObj->{$alias});
    }

    public function testInitMongoDb()
    {
        $testObj = new Process();
        $config = new Configuration();
        $testObj->setConfig($config);
        $alias = 'mongo3434';
        $testObj->initMOngoDb($alias);
        $this->assertInstanceOf(MongoDb::class, $testObj->{$alias});
    }

    /**
     * @expectedException TypeError
     */
    public function testOptionsOne()
    {
        $testObj = new Process();
        $options = rand(1, 20000);
        $testObj->setOptions($options);
    }

    public function testOptionsTwo()
    {
        $testObj = new Process();
        $options = [
            'attr1' => true,
            'attr2' => [1, 3, 8],
            'attr3' => 'awsome',
        ];

        $testObj->setOptions($options);
        $this->assertEquals($options, $testObj->getOptions());
    }
}
