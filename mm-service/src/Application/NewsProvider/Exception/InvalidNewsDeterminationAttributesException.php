<?php
declare(strict_types=1);

namespace App\Application\NewsProvider\Exception;

use InvalidArgumentException;
use Throwable;

class InvalidNewsDeterminationAttributesException extends InvalidArgumentException
{
    public function __construct(string $message, ?Throwable $previous = null)
    {
        $message = sprintf('Invalid news determination attributes: %s', $message);

        parent::__construct($message, 0, $previous);
    }
}
