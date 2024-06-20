<?php
declare(strict_types=1);

namespace App\Validator;

interface ValidatorInterface
{
    /**
     * @param mixed $data
     * @return void
     */
    public function setData(mixed $data): void;

    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return string
     */
    public function getMessage(): string;
}
