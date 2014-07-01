<?php
namespace Cliphpy\Lib\DAO;
use Cliphpy\Lib\Element;

class Postgresql extends Element
{
  /**
   * @var Dibi
   */
  protected $db;

  public function connect(){
    $arg = array(
      "driver"   => "postgre",
      "host"     => $this->config->{$this->alias}->address,
      "port"     => $this->config->{$this->alias}->port,
      "username" => $this->config->{$this->alias}->username,
      "password" => $this->config->{$this->alias}->password,
      "database" => $this->config->{$this->alias}->database,
    );
    $this->db = new \DibiConnection($arg);
  }

  public function isConnected(){
    try {
      return (bool) $this->db->fetchSingle("SELECT 1");
    } catch (DibiException $e){
      $this->log->error(json_encode($e));
      exit;
    }
  }

  /**
   * @param  integer $signal
   */
  public function close($signal){
    ;
  }

  /**
   * @return boolean
   */
  public function disconnect(){
    $this->db->disconnect();
    if (is_object($this->log)){
      $this->log->info("Postgre disconnected.");
    }
    return $this->db->isConnected();
  }

  public function setApplicationName(){
    $sql = "SET [application_name] = %s";
    $this->db->query($sql, $this->config->{$this->alias}->name);
  }

  /**
   * @return \Cliphpy\Lib\DAO\Postgresql
   */
  public function getInstance(){
    return clone $this;
  }

  /**
   * @return string
   */
  public function getVersion(){
    $sql = "SELECT version()";
    $version = $this->db->fetchSingle($sql);
    $sql = "SELECT now() - pg_postmaster_start_time()";
    $uptime = $this->db->fetchSingle($sql);
    $log = "%s, uptime %s";
    return sprintf($log, $version, $uptime);
  }

  /**
   * @param  array $set
   * @param  string $type
   * @return string
   */
  public function makePostgreArray($set, $type = null){
    settype($set, 'array');
    $result = array();
    switch ($type){
      case "character varying":
      case "text":
        $quoting = true;
        break;
      default:
        $quoting = false;
    }

    foreach ($set as $t){
      if (false === is_numeric($t)){
        $quoting = true;
        break;
      }
    }

    foreach ($set as $t){
      if (is_array($t)){
        $result[] = $this->makePostgreArray($t, $type);
      } else {
        $t = str_replace('"', '\\"', $t);
        if ($quoting){
          $t = '\'' . $t . '\'';
        }
        $result[] = $t;
      }
    }
    $return = "ARRAY[" . implode(",", $result) . "]";
    if (false === is_null($type)){
      $return .= "::" . $type . "[]";
    }
    return $return;
  }
}
