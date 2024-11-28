<?php

namespace SergeyShirykalov\EmailValidator;

class Validator
{
    /**
     * Проверяет email на корректность и на присутствие MX-записи в DNS
     * @param string $email
     * @return bool
     */
    public static function isValid(string $email): bool
    {
        // шаг 1 - проверяем с помощью регулярного выражения
        $check1 = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$check1) {
            return false;
        }

        // шаг 2 - проверяем по MX-записи в DNS
        $domain = substr(strrchr($email, "@"), 1);
        return getmxrr($domain, $mx_records);
    }
}
