<?php

use src\Check\Email;

require './vendor/autoload.php';

$arrayOfEmails = [
    'some@mail.ru',
    '@email.ru',
    'some@email',
    'som--asd---a_asde@mail.ru',
];
$emailChecker = new Email($arrayOfEmails);

require 'template-parts/global/header.php';
echo $emailChecker->getEmailCheckResult();
require 'template-parts/global/footer.php';
