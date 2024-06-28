<?php

declare(strict_types=1);

use Viking311\EmailChecker\Application\Application;

require 'vendor/autoload.php';

$emails = [
    '120@ya.ru',
    'test@test.ru',
    'tets@mail'
];

$app = new Application();
echo $app->run($emails)->render();
