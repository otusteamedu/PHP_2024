<?php
declare(strict_types=1);

namespace App\Domain\Validator\Exception;

class InvalidTitleFormatException extends InvalidTitleException
{
    public function __construct(string $value)
    {
        parent::__construct(sprintf('Invalid title: %s', $value));
    }
}
