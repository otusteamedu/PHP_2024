<?php

declare(strict_types=1);


require_once  dirname(__DIR__).'/vendor/autoload.php';


use App\Validation;

$app = new Validation();

$app->validatePost();