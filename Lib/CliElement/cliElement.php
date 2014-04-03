<?php
namespace Cliphpy\Lib;
use Cliphpy\Lib\Element;

class CliElement extends Element
{

  /**
   * @param  string $signal
   */
  public function close($signal){
    if (true === is_object($this->log)){
      $this->log->error("Terminated: " . $signal);
      $this->log->close($signal);
    }
  }
}