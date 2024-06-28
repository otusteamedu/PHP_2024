<?php

declare(strict_types=1);

namespace Viking311\EmailChecker\Validator;

class EmailFormat implements ValidatorInterface
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
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        return preg_match($regex, $this->data);
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return 'Incorrect format';
    }
}
