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
   * @var string
   */
  private $hostname;

  /**
   * @var boolean
   */
  private $writeStdout = false;

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
   * @param  integer $signal
   */
  public function close($signal){
    $this->write();
  }

  /**
   * @param string $msg
   */
  public function info($msg){
    $this->formatMessage("info", $msg);
  }

  /**
   * @param string $msg
   */
  public function error($msg){
    $this->formatMessage("error", $msg);
  }

  /**
   * @param string $msg
   */
  public function debug($msg){
    $this->formatMessage("debug", $msg);
  }

  public function attachHostname(){
    $this->hostname = gethostname();
  }

  public function write(){
    $this->writeLog("info");
    $this->writeLog("error");
    $this->writeLog("debug");
  }

  public function enableStdout(){
    $this->writeStdout = true;
  }

  /**
   * @param  string $thread
   * @param  string $msg
   */
  private function formatMessage($thread, $msg){
    $this->{$thread} = sprintf(
      "%s[%s]%s%s %s%s",
      $this->{$thread},
      date("c"),
      ($this->hostname ? sprintf(" [%s]", $this->hostname) : null),
      ($this->writeStdout ? sprintf(" [%s]", $thread) : null),
      $msg,
      PHP_EOL
    );
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
      if ($this->writeStdout){
        echo $this->{$name};
      }
      $this->{$name} = null;
    }
  }
}
