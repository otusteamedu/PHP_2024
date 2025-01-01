<?php

require __DIR__ . '/../vendor/autoload.php';

use Den\Hw6\EmailService;
use Den\Hw6\FileService;

$isCli = php_sapi_name() === 'cli';

if ($isCli) {
    $pathToEmails = !empty($argv[1]) && file_exists($argv[1])
        ? $argv[1]
        : (file_exists(__DIR__ . '/emails.txt') ? __DIR__ . '/emails.txt' : null);

    $validEmailAddresses = [];
    $notValidEmailAddresses = [];
    if (!empty($pathToEmails)) {
        $fileService = new FileService();
        $emailService = new EmailService();
        foreach ($fileService->getLines($pathToEmails) as $email) {
            if ($emailService->checkEmail($email)) {
                $validEmailAddresses[] = $email;
            } else {
                $notValidEmailAddresses[] = $email;
            }
        }
    }

    $result = 'Валидные email (' . count($validEmailAddresses) . ' шт.):' . PHP_EOL;
    $result .= implode(PHP_EOL, $validEmailAddresses) . PHP_EOL . PHP_EOL;

    $result .= 'Не валидные email (' . count($notValidEmailAddresses) . ' шт.):' . PHP_EOL;
    $result .= implode(PHP_EOL, $notValidEmailAddresses) . PHP_EOL;

    echo $result;
}
