<?php
namespace Cliphpy\Prototypes;

abstract class Settings
{

  /**
   * @var string
   */
  public $logDir = __DIR__ . "/../log";

  /**
   * @var string
   */
  public $pidDir = __DIR__ . "/../pid";
}