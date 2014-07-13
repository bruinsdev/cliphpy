<?php
namespace Cliphpy\Lib\DAO;
use \Cliphpy\Lib\Element;

abstract class Model extends Element
{

  /**
   * @param  integer $signal
   */
  public function close($signal){

  }

  public function setInstance($instance){
    $this->dao = $instance;
  }

  public function setDatabase(){
    $this->db = $this->dao->getDatabase();
  }
}