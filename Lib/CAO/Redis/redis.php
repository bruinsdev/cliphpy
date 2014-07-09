<?php
namespace Cliphpy\Lib\CAO;
use
  Cliphpy\Lib\Element,
  Cliphpy\Lib\Exception;

class Redis extends Element
{

  /**
   * @var Redis
   */
  private $redis;

  /**
   * @var string
   */
  private $key;

  /**
   * @var integer
   */
  private $countGet = 0;

  /**
   * @var integer
   */
  private $countSet = 0;

  public function close($signal){
    $this->disconnect();
    $this->log->info("Redis disconnected.");
  }

  public function connect(){
    $this->redis = new \Redis;
    $this->redis->connect($this->config->{$this->alias}->address,
      $this->config->{$this->alias}->port);
    $this->redis->select($this->config->{$this->alias}->idDatabase);
  }

  public function disconnect(){
    $this->redis->close();
  }

  /**
   * @param  string|array $key
   * @return null|string|boolean|array|object
   */
  public function get(){
    $this->countGet++;
    $key = func_get_args();
    $this->caller();
    $this->generateKey($key);
    $value = unserialize($this->redis->get($this->key));
    if (false === $value){
      return null;
    }
    return $value;
  }

  /**
   * @param string|boolean|array|object $value
   * @param string|array|null $key
   * @return null|string|boolean|array|object
   */
  public function set($value, $key = null){
    $this->countSet++;
    $this->caller();
    $this->generateKey($key);
    return $this->redis->set($this->key, serialize($value));
  }

  /**
   * @return boolean
   */
  public function flushAll(){
    $this->countGet = 0;
    $this->countSet = 0;
    return $this->redis->flushAll();
  }

  /**
   * @return float
   */
  public function getUsage(){
    if (0 === $this->countGet ||
        0 === $this->countSet
    ){
      return 0;
    }
    $usage = ($this->countGet) / ($this->countSet);
    $usage *= 100;
    $usage -= 100;
    return $usage;
  }

  /**
   * @return boolean
   * @throws RedisException If connection lost
   */
  public function isConnected(){
    try {
      if (is_array($this->redis->info())){
        return true;
      }
    } catch (\RedisException $e){}
    return false;
  }

  /**
   * @return string
   */
  public function getVersion(){
    if (is_null($this->redis)){
      throw new Exception("Error execute on Redis, disconnected", __LINE__);
    } else {
      $info = $this->redis->info();
      $msg = "Redis %s, uptime %d min %d sec, memory %s, memory peak %s, " .
        "memory fragmentation %.02f";
      return sprintf($msg, $info["redis_version"],
        ($info["uptime_in_seconds"] / 60), ($info["uptime_in_seconds"] % 60),
        $info["used_memory_human"], $info["used_memory_peak_human"],
        $info["mem_fragmentation_ratio"]);
    }
  }

  /**
   * @param integer|string|array|null $key
   */
  private function generateKey($key){
    if (is_null($key)){
      return $this->key;
    }
    if (is_array($key) && 1 === count($key)){
      $key = $key[0];
    }
    if (false === is_array($key)){
      $key = array($key);
    }
    $callerClass = str_replace("\\", ":", $this->callerClass);
    $caller = array($callerClass, $this->callerFunction);
    $this->key = implode(":", array_merge($caller, $key));
  }
}
