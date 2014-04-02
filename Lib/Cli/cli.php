<?php
namespace Cliphpy\Lib;

class Cli extends Element
{

  /**
   * @var string
   */
  private $shortOptions = "";

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


  public function getOptions(){
    $this->options = getopt($this->shortOptions, $this->longOptions);
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
      die(PHP_EOL . "Undefined child." . PHP_EOL);
    }
  }

  private function writePid(){
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

}