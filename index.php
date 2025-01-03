<?php

require_once("vendor/autoload.php");


$postData = file_get_contents('php://input');
//var_dump($postData);

$arEvent = json_decode($postData);
var_export($arEvent);



//$redis = new Redis();
//$redis->connect('redis');
//$id = $redis->get("event:counter");
//echo $id . "<br>";
//$incr = $redis->incr("event:counter");
//echo $incr . "<br>";
//$id = $redis->get("event:counter");
//echo $id . "<br>";
/**
echo "redis: " . ($redis->ping() ? "подключено" : "ошибка подключения");
echo "<br>";
 * /

/*
$mysql = new mysqli('mysql', 'otus', '123', null, null, "/usr/local/var/run/php-fpm.sock");
echo "mysql: " . (empty($mysql->connect_error) ? " подключено" : "ошибка подключения");
echo "<br>";
*/
