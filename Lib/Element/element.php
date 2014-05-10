<?php
namespace Cliphpy\Lib;
use
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
   * @var Cache
   */
  protected $cache;

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

  public function __construct(){
    declare(ticks = 1);
    $this->initSignalHandler();
  }

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
   * @param Cache $cache
   */
  public function setCache(Cache $cache){
    $this->cache = $cache;
  }

  /**
   * @param integer $idChild
   */
  public function setIdChild($idChild){
    $this->idChild = $idChild;
  }

  /**
   * @return integer
   */
  public function getIdChild(){
    return $this->idChild;
  }

  private function initSignalHandler(){
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

  protected function caller(){
    $trace = debug_backtrace();
    $this->callerFunction = $trace[2]["function"];
    $this->callerClass = $trace[2]["class"];
  }

  /**
   * @param  string $signal
   */
  abstract function close($signal);
}