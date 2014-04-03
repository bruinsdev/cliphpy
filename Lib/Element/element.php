<?php
namespace Cliphpy\Lib;
use
  Cliphpy\Lib\Log,
  Cliphpy\Prototypes\Configuration;

class Element
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
   * @var integer
   */
  protected $idChild;

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

  /**
   * @param  string $signal
   */
  abstract function close($signal);
}