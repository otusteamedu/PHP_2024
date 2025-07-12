<?php

require_once __DIR__ . '/code/vendor/autoload.php';

use VKomar\EmailValidator;

$validation = new EmailValidator();
$emails = $validation->checkEmails();
