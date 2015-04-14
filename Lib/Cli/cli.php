<?php
namespace Cliphpy\Lib;

if ("cli" !== PHP_SAPI) {
  die("This can only be run from the CLI!");
}

class Cli extends Element
{

  /**
   * @var string
   */
  private $shortOptions = "c:";

  /**
   * @var array
   */
  private $longOptions = array("child:");

  /**
   * @var array
   */
  private $options;

  /**
   * @var string
   */
  private $pidFile;

  /**
   * @var string
   */
  private $name;

  /**
   * @var string
   */
  private $usage;

  /**
   * @param  integer $signal
   */
  public function close($signal){
    if (true === is_object($this->log)){
      $this->log->error("Terminated: " . $signal);
      $this->log->close($signal);
    }
  }

  /**
   * @param array
   */
  public function setOptions($options){
    foreach ($options as $short => $long){
      $this->shortOptions .= $short;
      $this->longOptions[] = $long;
    }
  }

  /**
   * @return array
   */
  public function getOptions(){
    return array(
      "long"  => $this->longOptions,
      "short" => $this->shortOptions,
    );
  }

  public function readOptions(){
    $this->options = getopt($this->shortOptions, $this->longOptions);
  }

  /**
   * @return array
   */
  public function getReadedOptions(){
    return $this->options;
  }

  /**
   * @param string $name
   */
  public function setName($name){
    $this->name = preg_replace("~([\ ]+)~imus", "_", trim($name));
  }

  /**
   * @return string
   */
  public function getName(){
    return $this->name;
  }

  public function checkChild(){
    if (isset($this->options["child"])){
      $this->idChild = (int) $this->options["child"];
      if ($this->idChild >= 0){
        $format = "%s/%s-%d.pid";
        $this->pidFile = sprintf($format, $this->config->pidDir,
          $this->name, $this->idChild);
        if ($this->checkRunning()){
          $format = "%s Already running. Id child %d";
          die(sprintf($format, date("c"), $this->idChild) . PHP_EOL);
        } else {
          $this->writePid();
        }
      }
    } else {
      die($this->getUsage());
    }
  }

  /**
   * @param string $usage
   */
  public function setUsage($usage){
    $this->usage = $usage;
  }

  /**
   * @return string
   */
  public function getUsage(){
    $usage = "Usage:" . PHP_EOL . PHP_EOL;
    $usage .= "-c, --child\t<integer>\t\tChild ID process";
    $usage .= PHP_EOL;
    if (false === is_null($this->usage)){
      $usage .= "Custom usage:" . PHP_EOL . PHP_EOL;
      $usage .= $this->usage . PHP_EOL;
    }
    return $usage;
  }

  private function writePid(){
    $this->checkPidDirectory();
    file_put_contents($this->pidFile, getmypid());
  }

  public function removePid(){
    unlink($this->pidFile);
  }

  /**
   * @return boolean
   */
  private function checkRunning(){
    if (is_file($this->pidFile)){
      $prevPid = (int) trim(file_get_contents($this->pidFile));
      $cmd = sprintf("ps -p %d -o pid=", $prevPid);
      $test = (int) trim(exec($cmd));
      if ($prevPid === $test){
        return true;
      } else {
        return false;
      }
    }
    return false;
  }

  private function checkPidDirectory(){
    $pidDir = dirname($this->pidFile);
    if (false === is_dir($pidDir)){
      mkdir($pidDir, 0744, true);
    }
  }
}
