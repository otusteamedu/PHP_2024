<?php

$redis = new Redis();
$redis->connect('redis', '6379');
$redis->auth('qwerty');
if ($redis->ping()) {
    echo "<br> Redis  is ";
    $redis->set("redis", "WORKING!");
}
echo $redis->get("redis") . '<br><br>';

$mem = new Memcached();
$mem->addServer('memcached', 11211);
$mem->set('int', 99);
var_dump($mem->get('int')  . '<br>');
$mem->set('string', '<br> Memcached is WORKING!');
var_dump($mem->get('string') . '<br>');

$connect_data = sprintf(
    "pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s",
    'postgresql',
    '5432',
    'pdb',
    'kyberlox',
    '1111'
);
$dbh = new PDO($connect_data);
echo "<br><br> PostgeSQL is WORKING! <br>";

echo "<br> by Kyberlox <br>";
