<?php
declare(strict_types=1);

namespace App\Services\EmailVerificationService;

use App\Services\EmailVerificationService\Exceptions\EmailValidateException;

class EmailVarificator
{
    public array $emails;

    public function __construct($emails)
    {
        $this->emails = $emails;
    }

    /**
     * @return array|void
     * @throws EmailValidateException
     */
    public function emailsVarify()
    {
        if ($this->isEmpty()) {
            if ($this->isStringItemData()) {
                return $this->checkDNSMXRecord(array_combine($this->emails, $this->emailsFilter()));
            }
        }
    }

    /**
     * @return mixed
     */
    private function emailsFilter(): mixed
    {
        return $this->emails = filter_var($this->emails, FILTER_VALIDATE_EMAIL, FILTER_REQUIRE_ARRAY);
    }

    /**
     * @param array $array
     * @return array
     */
    public function checkDNSMXRecord(array $array): array
    {
        $valid_emails = [];
        foreach ($array as $key => $item) {
            if ($item) {
                $domain = explode('@' ,$item)[1];
                $valid_emails[$item] = checkdnsrr($domain, 'MX');
            } else {
                $valid_emails[$key] = false;
            }
        }
        return $valid_emails;
    }

    /**
     * @throws EmailValidateException
     */
    private function isStringItemData(): bool
    {
        for ($i = 0; $i < count($this->emails); $i++) {
            if (!is_string($this->emails[$i])) {
                $type = gettype($this->emails[$i]);
                throw new EmailValidateException("value must be a string! $type is given ");
            }
        }
        return true;
    }

    /**
     * @return true
     * @throws EmailValidateException
     */
    public function isEmpty(): bool
    {
        if ($this->emails == []) {
            throw new EmailValidateException("value must not be empty!");
        }
        return true;
    }
}
