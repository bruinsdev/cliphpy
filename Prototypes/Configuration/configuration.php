<?php
namespace Cliphpy\Prototypes;

class Configuration implements iConfiguration
{
  /**
   * @var string
   */
  protected $environmentVariableName = "CLIPHPY_ENVIRONMENT";

  /**
   * @var string
   */
  protected $environment = "production";

  public function getConfig(){
    throw new \Exception("Configuration:getConfig is not defined.", 1);
  }

  protected function setEnvironment(){
    if (isset($_SERVER[$this->environmentVariableName])) {
      $this->environment = $_SERVER[$this->environmentVariableName];
    }
  }
}