<?php
namespace Cliphpy\Lib;

class Log
{
  /**
   * @var string
   */
  private $logDir;

  /**
   * @var string
   */
  private $info;

  /**
   * @var string
   */
  private $error;

  /**
   * @var string
   */
  private $debug;

  /**
   * @param string $logDir
   */
  public function setLogDir($logDir){
    $this->logDir = $logDir;
  }

  public function __destruct(){
    $this->write();
  }

  /**
   * @param  string $signal
   */
  public function close($signal){
    $this->write();
  }

  /**
   * @param string $msg
   */
  public function info($msg){
    $this->info .= "[" . date('c') . "] " . $msg . PHP_EOL;
  }

  /**
   * @param string $msg
   */
  public function error($msg){
    $this->error .= "[" . date('c') . "] " . $msg . PHP_EOL;
  }

  /**
    * @param string $msg
    */
  public function debug($msg){
    $this->debug .= "[" . date('c') . "] " . $msg . PHP_EOL;
  }

  public function write(){
    $this->writeLog("info");
    $this->writeLog("error");
    $this->writeLog("debug");
  }

  /**
   * @param  string $name
   */
  private function writeLog($name){
    if (false === is_null($this->{$name})){
      if (false === is_dir($this->logDir)){
        mkdir($this->logDir, 0777, true);
      }
      $filename = $this->logDir . "/" . $name . "_" . date("Y-m-d") . ".log";
      $fp = fopen($filename, "a");
      fwrite($fp, $this->{$name});
      fclose($fp);
      $this->{$name} = null;
    }
  }
}