<?php
namespace Cliphpy\Lib;
use
  Cliphpy\Interfaces\CommandLineInterface,
  Cliphpy\Lib\CliElement;

class Process extends CliElement implements CommandLineInterface
{

  /**
   * @param  integer $signal
   */
  public function close($signal){
    exit;
  }
}