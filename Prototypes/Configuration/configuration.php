<?php
namespace Cliphpy\Prototypes;

class Configuration
{

  /**
   * @var string
   */
  public $logDir;

  /**
   * @var string
   */
  public $pidDir;

  public function __construct(){
    $this->logDir = __DIR__ . "/../log";
    $this->pidDir = __DIR__ . "/../pid";
  }
}