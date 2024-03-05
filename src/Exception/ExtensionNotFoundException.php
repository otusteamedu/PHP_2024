<?php

declare(strict_types=1);

namespace Alogachev\Homework\Exception;

use RuntimeException;
use Throwable;

class ExtensionNotFoundException extends RuntimeException
{
    public function __construct(string $extensionName, ?Throwable $previous = null)
    {
        parent::__construct('Расширение ' . $extensionName . ' не обнаружено.', 1, $previous);
    }
}
