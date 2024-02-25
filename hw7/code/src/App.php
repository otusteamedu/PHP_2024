<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw7;

use GoroshnikovP\Hw7\Exception\AppException;

class App
{
    const EMAIL_LISTS_PATH = 'emails.txt';

    /**
     * @throws AppException
     */
    public function run(): array
    {
        if (!file_exists(static::EMAIL_LISTS_PATH)) {
            throw new AppException("Не найден файл " . static::EMAIL_LISTS_PATH);
        }

        $emailsList = file(static::EMAIL_LISTS_PATH);
        if (empty($emailsList)) {
            throw new AppException("Не найдены email");
        }

        foreach ($emailsList as &$email) {
            $email = trim($email);
        }
        unset($email);

        return (new EmailValidator())->validateEmailSList($emailsList);
    }
}
