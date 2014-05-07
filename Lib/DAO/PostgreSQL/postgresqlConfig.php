<?php
namespace Cliphpy\Lib\DAO\Postgresql;

class Configuration
{

  /**
   * @var string
   */
  public $address = "127.0.0.1";

  /**
   * @var integer
   */
  public $port = 5432;

  /**
   * @var string
   */
  public $username = "postgres";

  /**
   * @var string
   */
  public $password = "postgres";

  /**
   * @var string
   */
  public $database = "postgres";
}