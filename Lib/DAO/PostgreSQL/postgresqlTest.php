<?php
namespace Cliphpy\Lib\DAO;
use Cliphpy\Prototypes\Configuration;

class testPostgresql extends \PHPUnit_Framework_TestCase
{

  /**
   * @cover Postgre::connect
   * @cover Postgre::isConnected
   * @cover Postgre::disconnect
   */
  public function testConnect(){
    $alias = "postgresql";
    $testObj = new Postgresql;
    $testObj->setAlias($alias);

    $config = new Configuration;
    $config->{$alias} = new Postgresql\Configuration;
    $testObj->setConfig($config);
    $testObj->connect();

    $this->assertTrue($testObj->isConnected());
    $this->assertFalse($testObj->disconnect());
  }

  /**
   * @cover Postgresql::makePostgreArray
   */
  public function testMakePostgresqlArrayOne() {
    $testObj = new Postgresql;
    $input = array(3, 4);
    $expected = "ARRAY[3,4]";
    $result = $testObj->makePostgreArray($input);
    $this->assertEquals($result, $expected);
  }

  /**
   * @cover Postgresql::makePostgreArray
   */
  public function testMakePostgresqlArrayTwo() {
    $testObj = new Postgresql;
    $input = array('Team1', 'Team2');
    $expected = "ARRAY['Team1','Team2']";
    $result = $testObj->makePostgreArray($input);
    $this->assertEquals($result, $expected);
  }

  /**
   * @cover Postgresql::makePostgreArray
   */
  public function testMakePostgresqlArrayThree() {
    $testObj = new Postgresql;
    $input = array('Team"3', 'Tea""m4');
    $expected = "ARRAY['Team\\\"3','Tea\\\"\\\"m4']";
    $result = $testObj->makePostgreArray($input);
    $this->assertEquals($result, $expected);
  }

  /**
   * @cover Postgresql::makePostgreArray
   */
  public function testMakePostgresqlArrayFour() {
    $testObj = new Postgresql;
    $input = array(4409);
    $expected = "ARRAY[4409]";
    $result = $testObj->makePostgreArray($input);
    $this->assertEquals($result, $expected);
  }

  /**
   * @cover Postgresql::makePostgreArray
   */
  public function testMakePostgresqlArrayFive() {
    $testObj = new Postgresql;
    $input = array(1, 'x', 2);
    $expected = "ARRAY['1','x','2']";
    $result = $testObj->makePostgreArray($input);
    $this->assertEquals($result, $expected);
  }

  /**
   * @cover Postgresql::makePostgreArray
   */
  public function testMakePostgresqlArraySix() {
    $testObj = new Postgresql;
    $input = array("asdasd", "sdasdasda");
    $expected = "ARRAY['asdasd','sdasdasda']::text[]";
    $result = $testObj->makePostgreArray($input, "text");
    $this->assertEquals($result, $expected);
  }
}