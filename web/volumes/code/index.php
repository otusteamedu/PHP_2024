<?php

declare(strict_types=1);

require './vendor/autoload.php';

use RShevtsov\Hw5\App;

$emails = [
    '',
    'jdgxfv56867tgc',
    'tyutv@jyhhb.com',
    'test@test.com',
    'rommshef@yandex.ru',
];

(new App())->run($emails);
