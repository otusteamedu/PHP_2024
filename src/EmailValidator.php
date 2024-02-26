<?php

declare(strict_types=1);


namespace hw6;

class EmailValidator implements ValidatorInterface
{
    private $pattern = '/^[^@]*<[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?>$/';

    public function validate(string $string): bool
    {
        if (!$this->regexpEmail($string)) {
            return false;
        }

        if(!$this->checkDns($string)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $string
     * @return bool
     */
    private function checkDns(string $string): bool
    {
        $explodedString = explode('@', $string);
        $domain = array_pop($explodedString) . '.';

        return checkdnsrr($domain);
    }

    /**
     * @param string $string
     * @return bool
     */
    private function regexpEmail(string $string): bool
    {
        return preg_match($this->pattern, $string) !== false && filter_var($string, FILTER_VALIDATE_EMAIL);
    }
}
