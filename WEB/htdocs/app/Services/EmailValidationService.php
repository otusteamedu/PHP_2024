<?php

namespace app\Services;

class EmailValidationService
{
    public function validateEmail(string $email): bool
    {
        // Проверка формата email с помощью регулярного выражения
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Извлечение домена из email
        $domain = substr(strrchr($email, "@"), 1);

        // Проверка DNS MX-записи для домена
        return $this->checkDnsMxRecord($domain);
    }

    private function checkDnsMxRecord(string $domain): bool
    {
        return checkdnsrr($domain, "MX");
    }
}