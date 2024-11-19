<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Enum\ServiceMessage;

class EmailValidatorService
{
    private const PATTERN = '/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u';

    public function validateEmail(string $json): array|string
    {
        $validationResult = [];
        $emailList = json_decode($json, true)['check'];

        foreach ($emailList as $item) {
            $email      = trim($item['email']);
            $domain     = explode('@', $email)[1];
            $checkEmail = $this->checkRegex($email) && checkdnsrr($domain);

            $validationResult['checked'][] = [$email => $checkEmail];
        }

        return ServiceMessage::CheckEmailResult->value . json_encode($validationResult);
    }

    private function checkRegex(string $email): bool
    {
        return (bool)preg_match(self::PATTERN, $email);
    }
}
