<?php

declare(strict_types=1);

namespace App\src\Validators;

use Exception;

readonly class EmailValidator
{
    public function __construct(private string $email)
    {
    }

    /**
     * @throws Exception
     */
    public function validate(): string
    {
        $this->regxValidate() or throw new Exception("Email $this->email not valid");
        $this->dnsValidate() or throw new Exception("Email $this->email dns not valid");

        return $this->email;
    }

    private function regxValidate(): bool
    {
        return (bool)preg_match(
            "/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",
            $this->email
        );
    }

    private function dnsValidate(): bool
    {
        $emailDns = explode('@', $this->email);
        return checkdnsrr(end($emailDns));
    }
}
