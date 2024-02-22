<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw7;

class EmailFeatures
{
    public static function validateEmail(string $email): bool
    {
        return static::validateEmailByString($email) && static::validateEmailByMx($email);
    }

    /**
     * @param string[] $emailsList
     * @return bool[]
     */
    public static function validateEmailSList(array $emailsList): array
    {
        $result = [];
        foreach ($emailsList as $email) {
            $result[] = static::validateEmail($email);
        }

          return $result;
    }

    /**
    * проверяет, что строка по формату соответствует e-mail
     */
    private static function validateEmailByString(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
    * проверяет действительность mx записи e-mail
     * предполагается, что сама строка e-mail валидна.
     */
    private static function validateEmailByMx(string $email): bool
    {
        $domain = explode('@', $email)[1];
        $hosts = [];
// он не нужен, но он обязательный параметр...
        return getmxrr($domain, $hosts);
    }
}
