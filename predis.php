<?php

//debug function
require "vendor/predis/predis/src/Autoloader.php";
Predis\Autoloader::register();

$client = new Predis\Client([
    'scheme' => 'tcp',
    'host'   => 'localhost',
    'port'   => 6379,
]);

$client->connect();
$client->flushAll();

echo $client->zAdd('conditions:param1', 1000, 'event:event1').'<br/>';

echo $client->zAdd('conditions:param1', 2000, 'event:event2').'<br/>';
echo $client->zAdd('conditions:param2', 2000, 'event:event2').'<br/>';

echo $client->zAdd('conditions:param1', 3000, 'event:event3').'<br/>';
echo $client->zAdd('conditions:param2', 3000, 'event:event3').'<br/>';

var_dump($client->zRevRangeByScore('conditions:param1', 5000, 0, ['WITHSCORES'=>true])); // 
echo '<br/>';

//var_dump($clienredis->zRangeByScore('conditions:param1', 0, 5000, ['WITHSCORES'=>true])); // 
//echo '<br/>';

//var_dump($client->zUnion(['conditions:param1', 'conditions:param2'], NULL, 'max']));
$result_inter = $client->zInter(['conditions:param1', 'conditions:param2'], [], 'min', true); 
arsort($result_inter);
var_dump($result_inter); 

$client->disconnect();
