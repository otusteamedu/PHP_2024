<?php

ini_set('xdebug.var_display_max_depth', '10');
ini_set('xdebug.var_display_max_children', '256');
ini_set('xdebug.var_display_max_data', '1024');

error_reporting(E_ALL);

mb_internal_encoding("UTF-8");

require_once __DIR__ . '/autoload.php';

$CONFIG = include_once __DIR__.'/Core/config.php';

try {
    new \Core\Common($CONFIG);


    \Core\Common::setRedis('foo', 'bar');

    $value = \Core\Common::getRedis('foo');

    var_dump('redis: '.$value);


    \Core\Common::setMemcashed('foo', 'bar');

    $value = \Core\Common::getMemcashed('foo');

    var_dump('memcashed: '.$value);

} catch (Exception $exception) {
    var_dump($exception->getMessage());
}
