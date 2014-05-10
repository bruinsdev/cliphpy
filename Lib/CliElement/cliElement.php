<?php
namespace Cliphpy\Lib;
use
  Cliphpy\Interfaces\CommandLineInterface,
  Cliphpy\Lib\Element;

class CliElement extends Element implements CommandLineInterface
{

  /**
   * @param  integer $signal
   */
  public function close($signal){
    if (true === is_object($this->log)){
      $this->log->error("Terminated: " . $signal);
      $this->log->close($signal);
    }
  }
}