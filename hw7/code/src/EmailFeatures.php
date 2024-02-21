<?php

declare(strict_types=1);

namespace GoroshnikovP\Hw7;

use Exception;

/**
* Реализует singleton
 */
final class EmailFeatures
{
    public function validateEmail(string $email): bool
    {
        return $this->validateEmailByString($email) && $this->validateEmailByMx($email);
    }

    /**
     * @param string[] $emailsList
     * @return bool[]
     */
    public function validateEmailSList(array $emailsList): array
    {
        $result = [];
        foreach ($emailsList as $email) {
            $result[] = $this->validateEmail($email);
        }

          return $result;
    }

    /**
    * проверяет, что строка по формату соответствует e-mail
     */
    private function validateEmailByString(string $email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
    * проверяет действительность mx записи e-mail
     * предполагается, что сама строка e-mail валидна.
     */
    private function validateEmailByMx(string $email): bool
    {
        $domain = explode('@', $email)[1];
        $hosts = [];
// он не нужен, но он обязательный параметр...
        return getmxrr($domain, $hosts);
    }



    private static ?self $instance = null;
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }
}
