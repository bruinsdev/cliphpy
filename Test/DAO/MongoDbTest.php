<?php

namespace Test\Cliphpy\DAO;

use Cliphpy\DAO\MongoDb;
use Cliphpy\Prototype\Configuration;
use MongoDB\Database;
use PHPUnit\Framework\TestCase;

class MongoDbTest extends TestCase
{
    /**
     * @expectedException \Exception
     */
    public function testConnectOne()
    {
        $testObj = new MongoDb();
        $testObj->getVersion();
    }

    public function testConnectTwo()
    {
        $testObj = new MongoDb();
        $config = new Configuration();
        $config->mongo = new MongoDb\Configuration();
        $config->mongo->address = 'mongo';
        $testObj->setConfig($config);
        $testObj->connect();
        $testObj->setAlias($config->mongo->database);
        $database = $testObj->getDatabase();
        $this->assertInstanceOf(Database::class, $database);
        $version = $testObj->getVersion();
        $this->assertTrue(is_string($version));
        $testObj->close(1);
    }
}
