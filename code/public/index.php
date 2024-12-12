<?php

require '../vendor/autoload.php';

use Services\Email;

$emailTxt = __DIR__ . '/data/emails.txt';
$emails = new Email($emailTxt);
$emails->getReadableResult();

echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";
