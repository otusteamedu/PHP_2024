<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw7;

class App
{
    const EMAIL_LISTS_PATH = 'emails.txt';

    private static ?EmailValidator $validator = null;

    public function getValidator(): EmailValidator {
        if (empty(static::$validator)) {
            static::$validator = new EmailValidator();
        }
        return static::$validator;
    }

    public function run(): void
    {
        if (!file_exists(static::EMAIL_LISTS_PATH)) {
            echo "Не найден файл " . static::EMAIL_LISTS_PATH;
            return;
        }

        $emailsList = file(static::EMAIL_LISTS_PATH);
        if (empty($emailsList)) {
            echo "Не найдены email";
            return;
        }

        foreach ($emailsList as &$email) {
            $email = trim($email);
        }
        unset($email);

        $validationList = $this->getValidator()->validateEmailSList($emailsList);

        echo "--------\n";
        foreach ($validationList as $item) {
            echo ($item ? '+' : '-') . "\n";
        }
        echo "--------\n";
    }
}
