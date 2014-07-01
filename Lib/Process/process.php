<?php
namespace Cliphpy\Lib;
use Cliphpy\Lib\Element;

class Process extends Element
{
  /**
   * @param  integer $signal
   */
  public function close($signal){
    ;
  }

  /**
   * @param  string $alias
   */
  public function initPostgresql($alias = "postgre"){
    $this->{$alias} = new DAO\Postgresql;
    $this->{$alias}->setAlias($alias);
    $this->{$alias}->setConfig($this->config);
  }

  /**
   * @param  string $alias
   */
  public function initRedis($alias = "redis"){
    $this->{$alias} = new CAO\Redis;
    $this->{$alias}->setAlias($alias);
    $this->{$alias}->setConfig($this->config);
  }

  /**
   * @param  string $alias
   */
  public function initMongoDb($alias = "mongo"){
    $this->{$alias} = new DAO\MongoDb;
    $this->{$alias}->setAlias($alias);
    $this->{$alias}->setConfig($this->config);
  }

  /**
   * @param array $options
   */
  public function setOptions($options){
    if (false === is_array($options)){
      throw new \Exception("options aren't array", __LINE__);
    }
    $this->options = $options;
  }

  /**
   * @return array
   */
  public function getOptions(){
    return $this->options;
  }
}
