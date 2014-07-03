<?php
namespace Cliphpy\Lib\DAO;
use
  Cliphpy\Lib\Element,
  Cliphpy\Lib\Exception;

class MongoDb extends Element
{
  /**
   * @var MongoClient
   */
  protected $mongo;

  /**
   * @param  integer $signal
   */
  public function close($signal){
    if (false === is_null($this->mongo)){
      $this->mongo->close();
    }
  }

  /**
   * @throws new Exception if Mongo cannot connect
   */
  public function connect(){
    $argf = "mongodb://%s:%d";
    $server = sprintf($argf, $this->config->mongo->address,
      $this->config->mongo->port);
    $this->mongo = new \MongoClient($server);
  }

  /**
   * @param  string $alias
   * @return MongoDb
   */
  public function getDatabase($alias = null){
    if (is_null($alias)){
      $alias = $this->alias;
    }
    return $this->mongo->{$alias};
  }

  /**
   * @return string
   */
  public function getVersion(){
    if (is_null($this->mongo)){
      throw new \Exception("Error execute on MongoDB, disconnected", __LINE__);
    } else {
      $status = $this->mongo->{$this->alias}->execute("db.serverStatus()");
      $msg = "MongoDB %s, uptime %d min %d sec";
      return sprintf($msg, $status["retval"]["version"],
        $status["retval"]["uptime"] / 60,
        $status["retval"]["uptime"] % 60);
    }
  }

  /**
   * @return boolean
   */
  public function isConnected(){
    return $this->mongo->connected;
  }
}
