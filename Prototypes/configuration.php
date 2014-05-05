<?php
namespace Cliphpy\Prototypes;

class Configuration
{
  /**
   * @var string
   */
  public $logDir = __DIR__ . "/../log";

  /**
   * @var string
   */
  public $pidDir = __DIR__ . "/../pid";

  /**
   * @var string
   */
  protected $environmentVariableName = "CLIPHPY_ENVIRONMENT";

  /**
   * @var string
   */
  private $environment = "production";

  public function __construct(){
    ;
  }

  public function getConfig(){
    throw new \Exception("Configuration:getConfig is not defined.", 1);
  }

  private function setEnvironment(){
    if (isset($_SERVER[$this->environmentVariableName])) {
      $this->environment = $_SERVER[$this->environmentVariableName];
    }
  }
}