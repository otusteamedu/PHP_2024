<?php

require '../vendor/autoload.php';

use Services\Email;

$emailTxt = __DIR__ . '/data/emails.txt';
$emails = new Email($emailTxt);
echo $emails->getReadableResult();
