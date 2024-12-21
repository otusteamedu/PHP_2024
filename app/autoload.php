<?php

declare(strict_types=1);

/**
 * @param $class_name
 *
 * @return false|void
 */
function autoloader($class_name)
{
    $file = __DIR__ . '/' . implode('/', explode("\\", $class_name)) . '.php';

    if (!file_exists($file)) {
        return false;
    }

    include $file;
}

spl_autoload_register('autoloader');