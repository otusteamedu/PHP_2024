<?php

declare(strict_types=1);

require_once __DIR__ . '../../vendor/autoload.php';

use FTursunboy\PhpWebservers\Application;

echo (new Application())->execute();
