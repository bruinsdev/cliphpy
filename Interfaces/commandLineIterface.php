<?php
namespace Cliphpy\Interfaces;

interface CommandLineInterface
{

  /**
   * @param  integer $signal
   */
  public function close($signal);
}