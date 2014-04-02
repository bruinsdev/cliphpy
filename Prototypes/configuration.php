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

  public function __construct(){
    ;
  }
}