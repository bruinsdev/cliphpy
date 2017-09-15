<?php

namespace Cliphpy\DAO;

use Cliphpy\Element;
use Cliphpy\Exception;
use MongoDB\Driver\Manager;

class MongoDb extends Element
{
    /**
     * @var Manager
     */
    protected $mongo;

    /**
     * @param int $signal
     */
    public function close($signal)
    {
        if (false === is_null($this->mongo)) {
            $this->mongo->close();
        }
    }

    /**
     * @throws new Exception if Mongo cannot connect
     */
    public function connect()
    {
        $argf = 'mongodb://%s:%d';
        $server = sprintf($argf, $this->config->mongo->address,
        $this->config->mongo->port);
        $this->mongo = new Manager($server);
    }

    /**
     * @param string $alias
     *
     * @return MongoDb
     */
    public function getDatabase($alias = null)
    {
        if (is_null($alias)) {
            $alias = $this->alias;
        }

        return $this->mongo->{$alias};
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        if (is_null($this->mongo)) {
            throw new \Exception('Error execute on MongoDB, disconnected', __LINE__);
        }

        $status = $this->mongo->{$this->alias}->command('db.serverStatus()');
        $msg = 'MongoDB %s, uptime %d min %d sec';

        return sprintf(
            $msg, $status['retval']['version'],
            $status['retval']['uptime'] / 60,
            $status['retval']['uptime'] % 60
        );
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return $this->mongo->connected;
    }
}
