<?php

declare(strict_types=1);

use Rmulyukov\Hw\App;
use Rmulyukov\Hw\AppMod;
use Rmulyukov\Hw\Factory\LongItemFactory;
use Rmulyukov\Hw\Factory\ShortItemFactory;

require_once __DIR__ . "/../vendor/autoload.php";

try {
    $mod = AppMod::from($argv[1] ?? '');
    $factory = $mod === AppMod::Long ? new LongItemFactory() : new ShortItemFactory();

    $path = $argv[2] ?? __DIR__;
    echo (new App($factory))->run($path) . "\n";
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}