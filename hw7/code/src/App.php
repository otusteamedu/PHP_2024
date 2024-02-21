<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw7;

class App
{
    const EMAIL_LISTS_PATH = 'emails.txt';


    public function run(): void
    {
        if (!file_exists(static::EMAIL_LISTS_PATH)) {
            echo "Не найден файл " . static::EMAIL_LISTS_PATH;
            return;
        }

        $emailService = EmailFeatures::getInstance();

        $emailsList = file(static::EMAIL_LISTS_PATH);
        if (empty($emailsList)) {
            echo "Не найдены email";
            return;
        }

        foreach ($emailsList as &$email) {
            $email = trim($email);
        }
        unset($email);

        $validationList = $emailService->validateEmailSList($emailsList);

        echo "--------\n";
        foreach ($validationList as $item) {
            echo ($item ? '+' : '-') . "\n";
        }
        echo "--------\n";
    }
}
