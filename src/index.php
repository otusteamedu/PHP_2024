<?php

declare(strict_types=1);

use AntonKuzmicev\DataValidator\Validator;

require_once '../vendor/autoload.php';

$validator = new Validator();

echo $validator->isValidEmail('test@gmail.com') . PHP_EOL;
echo $validator->isValidURL('https://google.com') . PHP_EOL;
echo $validator->isValidPhoneNumber('7123456789') . PHP_EOL;
