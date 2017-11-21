<?php
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//$redis = new Redis();
//$redis->connect('127.0.0.1', 6379);
//echo "Server is running: ".$redis->ping();

$memcached = new Memcached();
$memcached->addServer("127.0.0.1", 11211);
//$memcached->set('A', 'a', null);
//
//$memcached->set('C', 'c', null);
//
//$memcached->set('B', 'b', null);
//$memcached->delete('B');
//var_dump($memcached->get('key'));

$result = $memcached->getMulti(['A', 'B', 'C']);

foreach (['A', 'B', 'C'] as $value) {
	if (!array_key_exists($value, $result)) {
		$result[$value] = 'Nice!';
	}
}

//foreach ($result as $key => $value) {
//	echo "$key is $value;";
//}

var_dump($result);