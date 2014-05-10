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

  /**
   * @param array $options
   */
  public function setOptions($options){
    $this->options = $options;
  }

  /**
   * @return array
   */
  public function getOptions(){
    return $this->options;
  }
}
