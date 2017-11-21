<?php

namespace App\Realisation;
use \App\Interfaces\CacheInterface;
use Redis;
use App\Exceptions\InvalidArgumentException;

class CacheRedis implements CacheInterface {

    /**
     * @var Redis
     */
    private $redis;

    const REDIS_PORT = 6379;

    /**
     * CacheRedis constructor.
     * @param Redis $redis
     * @param string $host
     */
    public function __construct(Redis $redis, $host = '127.0.0.1') {
        $this->redis = $redis;
        $this->redis->connect($host, self::REDIS_PORT);
    }

    /**
     * @param string $key
     * @param null $default
     * @return InvalidArgumentException|bool|null|string
     */
    public function get($key, $default = null) {
        if (!is_string($key)) {
            return new InvalidArgumentException("In get key must be string");
        }

        if ($this->redis->exists($key)) {
            return $this->redis->get($key);
        }

        return $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param null|int $ttl
     * @return InvalidArgumentException|bool
     */
    public function set($key, $value, $ttl = null) {
        if (!is_string($key)) {
            return new InvalidArgumentException("In get key must be string");
        }

        if (empty($ttl)) {
            return $this->redis->set($key, $value);
        }

        return $this->redis->psetex($key, $ttl, $value);
    }

    /**
     * @param string $key
     * @return InvalidArgumentException|bool
     */
    public function delete($key) {
        if (!is_string($key)) {
            return new InvalidArgumentException("In get key must be string");
        }

        $numberDeleted = $this->redis->del($key);

        if ($numberDeleted < 1) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function clear() {
        return $this->redis->flushAll();
    }

    /**
     * @param iterable $keys
     * @param null $default
     * @return InvalidArgumentException|array
     */
    public function getMultiple($keys, $default = null) {
        if (!is_array($keys)) {
            return new InvalidArgumentException("Keys mast be array");
        }

        foreach ($keys as $valueKey) {
            if (!is_string($valueKey)) {
                return new InvalidArgumentException("All keys in keyArray must be string");
            }
        }

        $values = $this->redis->mget($keys);
        foreach ($values as $key => $value) {
            if ($value === false) {
                $values[$key] = $default;
            }
        }

        return array_combine($keys, $values);
    }

    /**
     * @param iterable $values
     * @param null $ttl
     * @return InvalidArgumentException|bool
     */
    public function  setMultiple($values, $ttl = null) {
        if (!is_array($values)) {
            return new InvalidArgumentException('Values must be array');
        }

        $result = true;

        if (isset($ttl)) {
            foreach ($values as $key => $value) {
                $result = $result && ($this->redis->psetex($key, $ttl, $value));
            }

            return $result;
        }

        return $this->redis->mset($values);
    }

    /**
     * @param iterable $keys
     * @return InvalidArgumentException|bool
     */
    public function deleteMultiple($keys) {
        if (!is_array($keys)) {
            return new InvalidArgumentException('Keys must be array');
        }

        $countDeletedValues = 0;

        foreach ($keys as $value) {
            if (!is_string($value)) {
                return new InvalidArgumentException('All value in keys must be string');
            }

            $countDeletedValues += $this->redis->del($value);
        }

        if ($countDeletedValues === count($keys)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     * @return InvalidArgumentException|bool
     */
    public function has($key) {
        if (!is_array($key)) {
            return new InvalidArgumentException('Key must be array');
        }

        return $this->redis->exists($key);
    }
}