<?php
namespace Cliphpy\Prototypes;

class Settings implements iSettings
{
  /**
   * @var string
   */
  protected $environmentVariableName = "CLIPHPY_ENVIRONMENT";

  /**
   * @var string
   */
  protected $environment = "production";

  public function getSettings(){
    throw new \Exception("Configuration:getSettings is not defined.", 1);
  }

  protected function setEnvironment(){
    if (isset($_SERVER[$this->environmentVariableName])) {
      $this->environment = $_SERVER[$this->environmentVariableName];
    }
  }
}