<?php

namespace Ekonyaeva\Otus\Services;

use Ekonyaeva\Otus\Interfaces\EmailValidatorInterface;
class EmailValidator implements EmailValidatorInterface
{
    private array $mxCheckResult = [];

    public function validate(array $emails): array
    {
        $results = [];

        foreach ($emails as $email) {
            $results[$email] = $this->verifyEmail($email);
        }

        return $results;
    }

    private function verifyEmail(string $email): array
    {
        $result = [
            'is_valid' => false,
            'is_valid_format' => false,
            'is_valid_dns' => null,
            'errors' => []
        ];

        if (!$this->validateFormat($email)) {
            $result['errors'][] = 'Invalid email format';
            return $result;
        }

        $result['is_valid_format'] = true;

        $domain = $this->extractDomain($email);

        if (!$this->checkDnsMx($domain)) {
            $result['errors'][] = 'No MX records found for domain';
            $result['is_valid_dns'] = false;
            return $result;
        }

        $result['is_valid_dns'] = true;
        $result['is_valid'] = true;
        return $result;
    }

    private function validateFormat(string $email): bool
    {
        $pattern = '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/';

        return (bool)preg_match($pattern, $email);
    }

    private function extractDomain(string $email): string
    {
        return substr($email, strpos($email, '@') + 1);
    }

    private function checkDnsMx(string $domain): bool
    {
        if (empty($domain)) {
            return false;
        }

        if (!array_key_exists($domain, $this->mxCheckResult)) {
            $this->mxCheckResult[$domain] = checkdnsrr($domain);
        }

        return checkdnsrr($domain);
    }

    public static function printValidationResults(array $results): void
    {
        echo '<pre>';
        print_r($results);
        echo '</pre>';
    }
}