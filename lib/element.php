<?php
namespace Cliphpy\Lib;

class Element
{

  /**
   * @var Config
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
   * @param Config $config
   */
  public function setConfig(Config $config){
    $this->config = $config;
  }

  /**
   * @param Log $log
   */
  public function setLog(Log $log){
    $this->log = $log;
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