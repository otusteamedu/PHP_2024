<?php
declare(strict_types=1);

namespace App\Domain\Validator\Exception;

class InvalidUrlFormatException extends InvalidUrlException
{
    public function __construct(string $value)
    {
        $message = sprintf('Invalid URL: %s', $value);
        parent::__construct($message);
    }
}
