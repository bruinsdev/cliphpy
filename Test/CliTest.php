<?php

namespace Test\Cliphpy\Cli;

use Cliphpy\Cli;
use PHPUnit\Framework\TestCase;

class CliTest extends TestCase
{
    public function testClose()
    {
        $testObj = new Cli();
        $testObj->close(1);
    }

    public function testSetName()
    {
        $testObj = new Cli();
        $name = ' CLI name testing ';
        $expected = 'CLI_name_testing';
        $testObj->setName($name);
        $this->assertEquals($expected, $testObj->getName());
    }

    public function testSetOptions()
    {
        $testObj = new Cli();
        $options = [
            't:' => 'test:',
            'q::' => 'quit::',
            'v' => 'verbose',
        ];
        $testObj->setOptions($options);
        $actual = $testObj->getOptions();
        $expected = [
            'short' => 'c:t:q::v',
            'long' => [
                'child:',
                'test:',
                'quit::',
                'verbose',
            ],
        ];
        $this->assertEquals($expected, $actual);
    }

    public function testUsage()
    {
        $testObj = new Cli();
        $usage = $testObj->getUsage();
        $this->assertTrue(is_string($usage));
        $customUsage = 'This is custom usage, only for testing';
        $testObj->setUsage($customUsage);
        $expected = $usage.'Custom usage:'.PHP_EOL.PHP_EOL;
        $expected .= $customUsage.PHP_EOL;
        $actual = $testObj->getUsage();
        $this->assertEquals($expected, $actual);
    }
}
