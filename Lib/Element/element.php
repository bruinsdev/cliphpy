<?php
namespace Cliphpy\Lib;
use
  Cliphpy\Lib\CAO\Redis,
  Cliphpy\Lib\DAO\MongoDb,
  Cliphpy\Lib\DAO\Postgresql,
  Cliphpy\Lib\Log,
  Cliphpy\Prototypes\Configuration;

abstract class Element
{

  /**
   * @var Configuration
   */
  protected $config;

  /**
   * @var Log
   */
  protected $log;

  /**
   * @var string
   */
  protected $alias;

  /**
   * @var integer
   */
  protected $idChild;

  /**
   * @var string
   */
  protected $callerFunction;

  /**
   * @var string
   */
  protected $callerClass;

  /**
   * @var object
   */
  protected $dao;

  /**
   * @var double
   */
  private $startTimestamp;

  /**
   * @param Configuration $config
   */
  public function setConfig(Configuration $config){
    $this->config = $config;
  }

  /**
   * @return Configuration
   */
  public function getConfig(){
    return $this->config;
  }

  /**
   * @param string $alias
   */
  public function setAlias($alias = "alias"){
    if (false === is_string($alias)){
      throw new Exception("alias is not string", __LINE__);
    }
    $this->alias = $alias;
  }

  /**
   * @return string
   */
  public function getAlias(){
    return $this->alias;
  }

  /**
   * @param Log $log
   */
  public function setLog(Log $log){
    $this->log = $log;
  }

  /**
   * @return Log
   */
  public function getLog(){
    return $this->log;
  }

  /**
   * @param \Cliphpy\Lib\CAO\Redis $redis
   */
  public function setRedis(Redis $redis){
    $this->redis = $redis;
  }

  /**
   * @param Cliphpy\Lib\DAO\Postgresql $postgresql
   */
  public function setPostgresql(Postgresql $postgresql){
    $this->postgresql = $postgresql;
  }

  /**
   * @param object $dao
   */
  public function setDao($dao){
    if (false === is_object($dao)){
      throw new Exception("dao isn't object", __LINE__);
    }
    $this->dao = $dao;
  }

  /**
   * @param Cliphpy\Lib\DAO\MongoDb $mongo
   */
  public function setMongoDb(MongoDb $mongodb){
    $this->mongodb = $mongodb;
  }

  /**
   * @param integer $idChild
   */
  public function setIdChild($idChild){
    if (false === is_int($idChild)){
      throw new Exception("idChild isn't integer", __LINE__);
    }
    $this->idChild = $idChild;
  }

  /**
   * @return integer
   */
  public function getIdChild(){
    return $this->idChild;
  }

  /**
   * @param  null|integer|string|array|object $obj
   * @return string
   */
  public function getSumObject($obj){
    return md5(json_encode($obj));
  }

  /**
   * @param  null|integer|string|array|object $obj
   * @return double
   */
  public function getSumId($obj){
    $md5sum = $this->getSumObject($obj);
    $hash = base_convert($md5sum, 16, 10);
    return (double)substr($hash, 0, 9);
  }

  protected function start(){
    $this->caller();
    $key = $this->getDelayKey();
    $this->startTimestamp[$key] = microtime(true);
  }

  protected function stop(){
    $this->caller();
    $key = $this->getDelayKey();
    $msg = "DELAY: %s:%s -> %0.3f s";
    $log = sprintf($msg, $this->callerClass, $this->callerFunction,
      (microtime(true) - $this->startTimestamp[$key]));
    if (is_object($this->log)){
      $this->log->debug($log);
      $this->log->write();
    } else {
      echo $log . PHP_EOL;
    }
  }

  /**
   * @param  Object $object
   * @return array
   */
  protected function checkArray($object){
    if (false === is_array($object)){
      $tmp     = clone $object;
      $array   = array();
      $array[] = $tmp;
    } else {
      $array = $object;
    }
    return $array;
  }

  protected function caller(){
    $trace = debug_backtrace();
    $this->callerFunction = $trace[2]["function"];
    $this->callerClass = $trace[2]["class"];
  }

  /**
   * @param  array $array
   * @return \stdClass
   */
  protected function convertToObject($array){
    return json_decode(json_encode($array));
  }

  /**
   * @return string
   */
  private function getDelayKey(){
    return sprintf("%s|%s", $this->callerClass, $this->callerFunction);
  }

  private function initSignalHandler(){
    declare(ticks = 1);
    $obj = $this;
    $handler = function($signal) use($obj){$obj->signalHandler($signal); };
    pcntl_signal(SIGINT, $handler);
    pcntl_signal(SIGTERM, $handler);
  }

  /**
   * @param  string $signal
   */
  private function signalHandler($signal){
    switch ($signal) {
      case SIGINT:
        $type = "SIGINT";
        break;
      case SIGTERM:
        $type = "SIGTERM";
        break;
    }
    $msg = "Detected %s. Exiting.";
    $log = sprintf($msg, $type);
    if (true === is_object($this->log)){
      $this->log->info($log);
    }
    $this->close($signal);
    exit;
  }

  /**
   * @param  string $signal
   */
  abstract public function close($signal);
}
