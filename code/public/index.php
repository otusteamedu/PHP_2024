<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use Irayu\Hw6;

$emails = [
    'wrongem,ail@mail.ru', 'ri-ght.em1ail@gmail.com', 'really@bad@email', 'test@example.com',
];
$validator = new Hw6\EmailValidator();
?><ul><?php
foreach ($emails as $email) {
    echo '<li>' . htmlspecialchars($email) . ': ' . PHP_EOL;
    $result = $validator->check($email);
    if ($result->isSucceed()) {
        echo 'OK';
    } else {
        foreach ($result->getErrors() as $error) {
            echo htmlspecialchars($error->getMessage()) . '<br>' . PHP_EOL;
        }
    }
    echo '</li>' . PHP_EOL;
}
?></ul>