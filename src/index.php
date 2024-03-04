<?php

echo "Привет, Otus!<br>".date("Y-m-d H:i:s") ."<br><br>";

echo "111111";

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
echo $redis->ping();

//$memcached = new Memcached;
//
//$memcached->addServer('memcached', 11211);