<?php
declare(strict_types=1);

namespace App\Infrastructure\Report\Exception;

use InvalidArgumentException;

class FormatterNotFoundException extends InvalidArgumentException
{
    public function __construct(string $format)
    {
        $message = sprintf('Report formatter for "%s" format not found', $format);

        parent::__construct($message);
    }
}
