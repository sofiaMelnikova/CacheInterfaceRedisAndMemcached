<?php
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$redis = new Redis();

$redis->connect('127.0.0.1', 6379);
//echo "Server is running: ".$redis->ping();
//$redis->set('key1', false);
//$redis->set('key2', 'value2');
//var_dump($redis->mget(['key', 'key1', 'key2']));
