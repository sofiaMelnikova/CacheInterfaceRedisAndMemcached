<?php
require_once __DIR__ . "/vendor/autoload.php";
use App\Realisation\Factories;
use App\Realisation\CacheRedis;
use App\Realisation\CacheMemcached;

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$redis = (new Factories())->getRedis();
$memcached = (new Factories())->getMemcached();

$cacheRedis = (new CacheRedis($redis));
$cacheMemcached = (new CacheMemcached($memcached));