<?php
function auto($class_name)
{
    if (false === file_exists($path = __DIR__ . '/' . implode('/', explode("\\", $class_name)) . '.php')) {
        return false;
    }
    include $path;
}

spl_autoload_register('auto');

require_once __DIR__.'/vendor/autoload.php';
require __DIR__.'/vendor/Predis/predis/autoload.php';
Predis\Autoloader::register();
