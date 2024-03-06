<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use JackFrost\ValidateEmails\ValidateEmails;

$validate_emails = new ValidateEmails();

$result = $validate_emails->check([
    'a@a.com',
    'b@b-com',
    'c-c.com',
    'd@d@com',
]);

var_dump($result);
