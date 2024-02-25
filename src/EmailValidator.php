<?php

declare(strict_types=1);

namespace AShutov\Hw6;

use Exception;

class EmailValidator
{
    /**
     * @throws Exception
     */
    public function run(string $path)
    {
        $arrEmails = $this->readFile($path);

        return $this->validate($arrEmails);
    }

    /**
     * @throws Exception
     */
    public function readFile(string $path): array
    {
        $emails = [];

        if (!file_exists($path)) {
            throw new Exception("Файл не найден");
        }

        if ($lines = file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES)) {
            $emails = $lines;
        }

        return $emails;
    }

    public function validate(array $emails): string
    {
        $res = '';

        foreach ($emails as $email) {
            $explodeEmail = explode('@', $email);

            if (
                $this->checkRegex($email)
                && !empty($explodeEmail[1])
                && $this->checkDnsMx($explodeEmail[1])
            ) {
                $res .= 'Email ' . $email . ' валидный <br>';
            } else {
                $res .= 'Email ' . $email . ' невалидный <br>';
            }
        }

        return $res;
    }

    private function checkRegex(string $email): bool
    {
        return (bool)preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $email);
    }

    private function checkDnsMx(string $domain): bool
    {
        return checkdnsrr($domain);
    }
}
