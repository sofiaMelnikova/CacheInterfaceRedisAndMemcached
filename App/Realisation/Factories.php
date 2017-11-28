<?php

namespace App\Realisation;

class Factories {

	/**
	 * @param string $host
	 * @param int $port
	 * @param int $weight
	 * @return \Memcached
	 */
	public function getMemcached($host = '127.0.0.1', $port = 11211, $weight = 0) {
		$memcached = new \Memcached();
		$memcached->addServer($host, $port, $weight);
		return $memcached;
	}

	/**
	 * @param string $host
	 * @param int $port
	 * @param float $timeout
	 * @param null $reserved
	 * @param int $retry_interval
	 * @return \Redis
	 */
	public function getRedis($host = '127.0.0.1', $port = 6379, $timeout = 0.0, $reserved = null, $retry_interval = 0) {
		$redis = new \Redis();
		$redis->connect($host, $port, $timeout, $reserved, $retry_interval);
		return $redis;
	}

}