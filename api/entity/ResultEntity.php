<?php

declare(strict_types=1);

namespace api\entity;

use api\contracts\ErrorFormResponseInterface;

class ResultEntity
{
    private mixed $result;
    private ErrorFormResponseInterface $errorFormResponse;

    public function __construct(mixed $result, ErrorFormResponseInterface $errorFormResponse)
    {
        $this->result = $result;
        $this->errorFormResponse = $errorFormResponse;
    }

    public function getResult(): mixed
    {
        return $this->result;
    }

    public function hasError(): bool
    {
        return $this->errorFormResponse->hasErrors();
    }

    public function getErrors(): array
    {
        return $this->errorFormResponse->getErrors();
    }

    public function getFirstErrors(): array
    {
        return $this->errorFormResponse->getFirstErrors();
    }
}
