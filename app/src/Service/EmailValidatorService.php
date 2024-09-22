<?php

declare(strict_types=1);

namespace App\Service;

class EmailValidatorService
{
    private const PATTERN = '/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u';

    private const SEPARATOR = ';';

    /**
     * @param string|array $emailList
     * @param bool $arrayAsResult
     * @return array|string
     */
    public function validateEmail(string|array $emailList, bool $arrayAsResult = true): array|string
    {
        if (is_array($emailList)) {
            return $this->validateEmailArray($emailList, $arrayAsResult);
        }

        if (mb_substr(trim($emailList), -1) === self::SEPARATOR) {
            $emailList = mb_substr($emailList, 0, -1);
        }

        return $this->validateEmailArray(explode(self::SEPARATOR, $emailList), $arrayAsResult);
    }

    /**
     * @param array $emailList
     * @param bool $arrayAsResult
     * @return array|string
     */
    private function validateEmailArray(array $emailList, bool $arrayAsResult): array|string
    {
        $validationResult = $arrayAsResult ? [] : ' Email validation result:';

        foreach ($emailList as $email) {
            $email      = trim($email);
            $domain     = explode('@', $email)[1];
            $checkEmail = $this->checkRegex($email) && checkdnsrr($domain);

            if ($arrayAsResult) {
                $validationResult['ValidationResult'][] = [$email => $checkEmail];
            } else {
                $validationResult .= sprintf(' %s => %s;', $email,  ($checkEmail ? 'валиден' : 'не валиден'));
            }
        }

        return $validationResult;
    }

    /**
     * @param string $email
     * @return bool
     */
    private function checkRegex(string $email): bool
    {
        return (bool)preg_match(self::PATTERN, $email);
    }
}
