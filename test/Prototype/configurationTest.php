<?php

namespace Test\Cliphpy\Prototype;

use PHPUnit\Framework\TestCase;
use Cliphpy\Prototype\Configuration;

class ConfigurationTest extends TestCase
{
    public function testConstruct()
    {
        $testObj = new Configuration();

        $logDirExpected = __DIR__.'/../log';
        $pidDirExpected = __DIR__.'/../pid';

        //$this->assertEquals($logDirExpected, $testObj->logDir);
        //$this->assertEquals($pidDirExpected, $testObj->pidDir);
    }
}
