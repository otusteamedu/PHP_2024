<?php

declare(strict_types=1);

use SFadeev\Hw12\Kernel;

require_once(__DIR__ . '/../vendor/autoload.php');

$kernel = new Kernel();

$kernel->handle($argv);
