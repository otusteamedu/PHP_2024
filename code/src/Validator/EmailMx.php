<?php

declare(strict_types=1);

namespace Viking311\EmailChecker\Validator;

class EmailMx implements ValidatorInterface
{
    private string $data;

    /**
     * @inheritDoc
     */
    public function setData(mixed $data): void
    {
        $this->data = (string)$data;
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        $emailParts = explode('@', $this->data);
        $domaim = (count($emailParts) == 1) ? $this->data : $emailParts[1];
        return checkdnsrr($domaim);
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return 'Incorrect MX record';
    }
}
