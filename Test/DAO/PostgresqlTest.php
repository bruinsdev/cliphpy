<?php

namespace Test\Cliphpy\DAO;

use Cliphpy\DAO\Postgresql;
use Cliphpy\Prototype\Configuration;
use PHPUnit\Framework\TestCase;

class PostgresqlTest extends TestCase
{
    private $postgre = null;

    public function testConnect()
    {
        $alias = 'postgresql';
        $this->postgre = new Postgresql();
        $this->postgre->setAlias($alias);

        $config = new Configuration();
        $config->{$alias} = new Postgresql\Configuration();
        $config->{$alias}->address = 'postgres';
        $this->postgre->setConfig($config);
        $this->postgre->connect();

        $this->assertTrue($this->postgre->isConnected());
        $this->assertFalse($this->postgre->disconnect());
    }

    public function testClose()
    {
        $this->testConnect();
        $this->postgre->close(1);
    }

    public function testGetInstance()
    {
        $this->testConnect();
        $postgre = $this->postgre->getInstance();
        $this->assertInstanceOf(Postgresql::class, $postgre);
    }

    public function testGetVersion()
    {
        $this->testConnect();
        $version = $this->postgre->getVersion();
        $this->assertTrue(is_string($version));
    }

    public function testMakePostgresqlArrayOne()
    {
        $testObj = new Postgresql();
        $input = [3, 4];
        $expected = 'ARRAY[3,4]';
        $result = $testObj->makePostgreArray($input);
        $this->assertEquals($result, $expected);
    }

    public function testMakePostgresqlArrayTwo()
    {
        $testObj = new Postgresql();
        $input = ['Team1', 'Team2'];
        $expected = "ARRAY['Team1','Team2']";
        $result = $testObj->makePostgreArray($input);
        $this->assertEquals($result, $expected);
    }

    public function testMakePostgresqlArrayThree()
    {
        $testObj = new Postgresql();
        $input = ['Team"3', 'Tea""m4'];
        $expected = "ARRAY['Team\\\"3','Tea\\\"\\\"m4']";
        $result = $testObj->makePostgreArray($input);
        $this->assertEquals($result, $expected);
    }

    public function testMakePostgresqlArrayFour()
    {
        $testObj = new Postgresql();
        $input = [4409];
        $expected = 'ARRAY[4409]';
        $result = $testObj->makePostgreArray($input);
        $this->assertEquals($result, $expected);
    }

    public function testMakePostgresqlArrayFive()
    {
        $testObj = new Postgresql();
        $input = [1, 'x', 2];
        $expected = "ARRAY['1','x','2']";
        $result = $testObj->makePostgreArray($input);
        $this->assertEquals($result, $expected);
    }

    public function testMakePostgresqlArraySix()
    {
        $testObj = new Postgresql();
        $input = ['asdasd', 'sdasdasda'];
        $expected = "ARRAY['asdasd','sdasdasda']::text[]";
        $result = $testObj->makePostgreArray($input, 'text');
        $this->assertEquals($result, $expected);
    }
}
