<?php

declare(strict_types=1);


require_once  dirname(__DIR__).'/vendor/autoload.php';


use App\Response\Error400;
use App\Response\Success;
use App\Validation;
use App\Validators\RoundBrackets;

$app = new Validation(
    new Error400,
    new RoundBrackets,
    new Success
);

$app->validatePost();
