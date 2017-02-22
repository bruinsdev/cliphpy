<?php

namespace Cliphpy\Interface;

interface CommandLineInterface
{
  /**
   * @param  integer $signal
   */
  public function close($signal);
}
