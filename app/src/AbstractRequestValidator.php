<?php

declare(strict_types=1);

namespace Otus\Hw4;

abstract class AbstractRequestValidator
{
    const INT BAD_REQUEST_CODE = 400;
    const INT OK_CODE = 200;

    /**
     * @var array|string[]
     */
    protected array $allowedMethods = [];

    /** @var int|null */
    protected ?int $responseCode;

    /** @var string|null */
    protected ?string $message;

    /** @var array */
    protected array $errors = [];

    /**
     * @return int
     */
    public function getResponseCode(): int
    {
        return $this->responseCode;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return void
     */
    protected function setResponseParams(): void
    {
        $this->setResponseCode();
        $this->setMessage();
    }

    /**
     * @return void
     */
    protected function setResponseCode(): void
    {
        $this->responseCode = !empty($this->errors)
            ? self::BAD_REQUEST_CODE
            : self::OK_CODE;
    }

    /**
     * @return void
     */
    protected function setMessage(): void
    {
        $this->message = !empty($this->errors)
            ? $this->getErrors()
            : 'Verification successful';
    }

    /**
     * @param string $message
     * @return void
     */
    protected function addError(string $message): void
    {
        $this->errors[] = $message;
    }

    /**
     * @return string
     */
    protected function getErrors(): string
    {
        $result = '';
        foreach ($this->errors as $error) {
            $result .= $error . PHP_EOL;
        }

        return $result;
    }

    /**
     * @return void
     */
    abstract protected function validate(): void;
}
