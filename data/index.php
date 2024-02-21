<?php
declare(strict_types=1);

$arr = [];

$redis = new Redis();
$redis->connect('redis');
if ($redis->ping()) {
    $arr['redis'] = "Redis is work!";
}

$mc = new Memcached();
$mc->addServer("memcached", 11211);
$mc->set("memcached", "Memcached is work!");
$arr['memcached'] = $mc->get("memcached") ? $mc->get("memcached") : 'Memcached doesnt work ...';

$mysqli = new mysqli("mysql_db", "docker", "docker_pass", "db_docker");

$arr['db'] = $mysqli->host_info . "\n";

var_dump($arr);