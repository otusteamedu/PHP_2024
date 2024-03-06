<?php

declare(strict_types=1);

$path = dirname(__DIR__) . '/vendor/autoload.php';
echo $path;

use App\Validation\Validation;

$app = new Validation();

$app->validatePost();