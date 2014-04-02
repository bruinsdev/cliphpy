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
}