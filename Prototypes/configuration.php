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
  private $environment = "production";

  /**
   * @var string
   */
  private $environmentVariableName = "CLIPHPY_ENVIRONMENT";

  public function __construct(){
    ;
  }

  private function setEnvironment(){
    if (isset($_SERVER[$this->environmentVariableName])) {
      $this->environment = $_SERVER[$this->environmentVariableName];
    }
  }
}