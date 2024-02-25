<?php

declare(strict_types=1);

namespace Pozys\EmailValidator;

use Pozys\EmailValidator\Services\InputValidator;

require_once dirname(__DIR__) . '/vendor/autoload.php';

class Validator
{
    private InputValidator $inputValidator;

    public function __construct()
    {
        $this->inputValidator = new InputValidator();
    }

    public function verify(array $emails): array
    {
        $this->validateEmailsAreStrings($emails);

        return $this->getValidationResults($emails);
    }

    private function validateEmailsAreStrings(array $emails): void
    {
        if (!$this->inputValidator->onlyString($emails)) {
            throw new \InvalidArgumentException('All emails must be strings');
        }
    }

    private function getValidationResults(array $emails): array
    {
        return array_reduce($emails, function (array $result, string $email) {
            $result[$email] = $this->isRFC5322Compliant($email) && $this->hasDNSMXRecord($email);

            return $result;
        }, []);
    }

    private function isRFC5322Compliant(string $email): bool
    {
        $pattern = '/^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

        return (bool) preg_match($pattern, $email);
    }

    private function hasDNSMXRecord(string $email): bool
    {
        $domain = explode('@', $email)[1];

        return checkdnsrr($domain, 'MX');
    }
}
