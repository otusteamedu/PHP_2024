<?php

echo "Memcache TEST" . PHP_EOL;

$m = new Memcached();
$m->addServer('memcached', 11211);

$m->set('int', 99);
$m->set('string', 'a simple string');

var_dump($m->get('int') . PHP_EOL);
var_dump($m->get('string') . PHP_EOL);
