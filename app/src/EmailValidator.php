<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024;

class EmailValidator
{
    /**
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool
    {
        $explodeEmail = explode('@', $email);

        if (count($explodeEmail) === 2 && $this->checkByRegex($email) && $this->checkByMx($explodeEmail[1])) {
            return true;
        }

        return false;
    }

    /**
     * @param string $email
     * @return bool
     */
    private function checkByRegex(string $email): bool
    {
        return (bool) preg_match('/.+@.+\..+/', $email);
    }

    /**
     * @param string $domain
     * @return bool
     */
    private function checkByMx(string $domain): bool
    {
        return checkdnsrr($domain);
    }
}
