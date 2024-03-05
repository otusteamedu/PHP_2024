<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use SFadeev\Hw6\EmailValidationService;

$serv = new EmailValidationService();

$successExamples = [
    'test@gmail.com',
];

$wrongExamples = [
    'test@niiejdhdsd.ru',
];

$serv->validateBatch($successExamples);
$serv->validateBatch($wrongExamples);
