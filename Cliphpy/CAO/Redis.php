<?php

namespace Cliphpy\CAO;

use Cliphpy\Element;
use Cliphpy\Exception;

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
     * @var int
     */
    private $countGet = 0;

    /**
     * @var int
     */
    private $countSet = 0;

    /**
     * @param int $signal
     */
    public function close($signal)
    {
        $this->disconnect();
        $this->log->info('Redis disconnected.');
    }

    public function connect()
    {
        $this->redis = new \Redis();
        $this->redis->connect($this->config->{$this->alias}->address,
        $this->config->{$this->alias}->port);
        $this->redis->select($this->config->{$this->alias}->idDatabase);
    }

    public function disconnect()
    {
        $this->redis->close();
    }

    /**
     * @param string|array $key
     *
     * @return string|bool|array|object|null
     */
    public function get()
    {
        ++$this->countGet;
        $key = func_get_args();
        $this->caller();
        $this->generateKey($key);
        $value = unserialize($this->redis->get($this->key));

        if (false === $value) {
            return null;
        }

        return $value;
    }

    /**
     * @param string|bool|array|object $value
     * @param string|array|null        $key
     *
     * @return string|bool|array|object|null
     */
    public function set($value, $key = null)
    {
        ++$this->countSet;
        $this->caller();
        $this->generateKey($key);

        return $this->redis->set($this->key, serialize($value));
    }

    /**
     * @param string|bool|array|object $value
     * @param int                      $score
     * @param string|array|null        $key
     *
     * @return int
     */
    public function zadd($value, $score, $key = null)
    {
        $this->caller();
        $this->generateKey($key);

        return $this->redis->zadd($this->key, $score, serialize($value));
    }

    /**
     * @param string|bool|array|object $value
     * @param string|array|null        $key
     *
     * @return int
     */
    public function zrem($value, $key = null)
    {
        $this->caller();
        $this->generateKey($key);

        return $this->redis->zrem($this->key, $value);
    }

    /**
     * @param int               $from
     * @param int               $to
     * @param string|array|null $key
     *
     * @return array
     */
    public function zrange($from = 0, $to = -1, $key = null)
    {
        $this->caller();
        $this->generateKey($key);

        return $this->redis->zrange($this->key, $from, $to);
    }

    /**
     * @param string|array|null $key
     * @param int               $timeout
     *
     * @return bool
     */
    public function pexpire($key = null, $timeout = 1000)
    {
        $this->caller();
        $this->generateKey($key);

        return $this->redis->pexpire($this->key, $timeout);
    }

    /**
     * @param string $channel
     * @param string $message
     *
     * @return int
     */
    public function publish($channel, $message)
    {
        return $this->redis->publish($channel, $message);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return bool
     */
    public function flush()
    {
        $this->countGet = 0;
        $this->countSet = 0;

        return $this->redis->flushDB();
    }

    /**
     * @return bool
     */
    public function flushAll()
    {
        $this->countGet = 0;
        $this->countSet = 0;

        return $this->redis->flushAll();
    }

    /**
     * @return float
     */
    public function getUsage()
    {
        if (0 === $this->countGet ||
            0 === $this->countSet
        ) {
            return 0;
        }

        $usage = ($this->countGet) / ($this->countSet);
        $usage *= 100;
        $usage -= 100;

        return $usage;
    }

    /**
     * @return bool
     *
     * @throws RedisException If connection lost
     */
    public function isConnected()
    {
        try {
            if (is_array($this->redis->info())) {
                return true;
            }
        } catch (\RedisException $e) {
        }

        return false;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        if (is_null($this->redis)) {
            throw new Exception('Error execute on Redis, disconnected', __LINE__);
        }
        $info = $this->redis->info();
        $msg = 'Redis %s, uptime %d min %d sec, memory %s, memory peak %s, '.
                'memory fragmentation %.02f';

        return sprintf($msg, $info['redis_version'],
            ($info['uptime_in_seconds'] / 60), ($info['uptime_in_seconds'] % 60),
            $info['used_memory_human'], $info['used_memory_peak_human'],
            $info['mem_fragmentation_ratio']);
    }

    /**
     * @param int|string|array|null $key
     */
    private function generateKey($key)
    {
        if (is_null($key)) {
            return $this->key;
        }

        if (is_array($key) && 1 === count($key)) {
            $key = $key[0];
        }

        if (false === is_array($key)) {
            $key = [$key];
        }

        if (true === is_array($key) ||
            false === strpos($key, ':')
        ) {
            $callerClass = str_replace('\\', ':', $this->callerClass);
            $caller = [$callerClass, $this->callerFunction];
            $this->key = implode(':', array_merge($caller, $key));
        } else {
            $this->key = $key;
        }
    }
}
