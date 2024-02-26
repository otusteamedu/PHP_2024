<?php

declare(strict_types=1);

require './vendor/autoload.php';

use Lrazumov\Hw5\App;

$options = getopt('', ['mode:']);

(new App($options['mode'] ?? 'dev'))
    ->run();
