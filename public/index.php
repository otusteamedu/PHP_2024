<?php

use App\Services\EmailValidatorService;

require_once(__DIR__ . '/../vendor/autoload.php');

$service = new EmailValidatorService();

$result = $service->validate([
    'valid@gmail.com',
    'invalid@lalala.com'
]);

foreach ($result as $email => $status) {
    echo $email . ' is ' . ($status ? 'valid' : 'invalid') . PHP_EOL;
}
