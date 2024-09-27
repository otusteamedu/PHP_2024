<?php
declare(strict_types=1);

require_once '../src/EmailValidation.php';

$emails = [
    'pobert.barat@yandex.ru',
    'fwwq@eerfed.ew'
];

$checkEmails = new EmailValidation();

echo '<pre>';
var_dump($checkEmails->validate($emails));
echo '</pre>';
