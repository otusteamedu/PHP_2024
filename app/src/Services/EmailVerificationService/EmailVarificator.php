<?php

declare(strict_types=1);

namespace App\Services\EmailVerificationService;

use Exception;

class EmailVarificator
{
    public array $emails;

    public function __construct($emails)
    {
        $this->emails = $emails;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function emailsVarify(): array
    {
        $this->isEmpty();
        $validated_email = [];
        for ($i = 0; $i < count($this->emails); $i++) {
            $this->isStringItemData($this->emails[$i]);
            if ($this->emailsFilter($this->emails[$i]) == $this->emails[$i]) {
                $validated_email[$this->emails[$i]] = $this->checkDNSMXRecord($this->emails[$i]);
            } else {
                $validated_email[$this->emails[$i]] = false;
            }
        }
        return $validated_email;
    }

    /**
     * @param $value
     * @return mixed
     */
    private function emailsFilter($value): mixed
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param $value
     * @return bool
     */
    public function checkDNSMXRecord($value): bool
    {
        $domain = explode('@', $value)[1];
        return checkdnsrr($domain, 'MX');
    }

    /**
     * @param $value
     * @return void
     * @throws Exception
     */
    private function isStringItemData($value): void
    {
        if (!is_string($value)) {
            $type = gettype($value);
            throw new Exception("value must be a string! $type is given ");
        }
    }

    /**
     * @return void
     * @throws Exception
     */
    public function isEmpty(): void
    {
        if ($this->emails == []) {
            throw new Exception("value must not be empty!");
        }
    }
}
