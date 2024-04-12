<?php
declare(strict_types=1);

namespace App\Domain\Validator;

use App\Domain\Exception\InvalidArgumentException;

class InvalidUrlException extends InvalidArgumentException
{
    public function __construct(string $value)
    {
        $message = sprintf('Invalid URL: %s', $value);
        parent::__construct($message);
    }
}
