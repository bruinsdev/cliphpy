<?php
namespace Cliphpy\Lib;
use Cliphpy\Lib\CliElement;

class Process extends CliElement
{

  /**
   * @param  string $alias
   */
  public function initPostgresql($alias = "postgre"){
    $this->{$alias} = new DAO\Postgresql;
    $this->{$alias}->setAlias($alias);
    $this->{$alias}->setConfig($this->config);
  }

}
