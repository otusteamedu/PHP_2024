<?php

declare(strict_types=1);

namespace Otus\Hw6;

class EmailDnsValidator extends AbstractStringValidator
{
    /**
     * @param string|null $email
     * @return bool
     */
    public function validate(?string $email): bool
    {
        $this->checkDns($email);
        return !$this->hasErrors();
    }

    /**
     * @param string $email
     * @return void
     */
    private function checkDns(string $email): void
    {
        $domain = strrchr($email, "@");
        $domain = !empty($domain) ? substr($domain, 1) : '';

        if (empty($domain) || !checkdnsrr($domain)) {
            $this->addError("Email domain - $email does not have MX records.");
        }
    }
}
