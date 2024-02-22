<?php

use AlexanderPogorelov\EmailValidator\EmailValidator;

require dirname(__DIR__) . '/vendor/autoload.php';

$input = require './example.php';
$validator = new EmailValidator();
$result = $validator->validateEmails($input);

echo "<pre>";
print_r($input);
print_r($result);
echo "</pre>";
