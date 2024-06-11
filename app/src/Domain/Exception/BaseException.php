<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Exception;

use Exception;
use Throwable;

abstract class BaseException extends Exception
{
    protected const GENERATED_STATUS = 500;
    public function __construct($message = "", $code = BaseException::GENERATED_STATUS, Throwable $previous = null)
    {
        if (!empty($message) or (!empty($message) and !empty($code))) {
            parent::__construct($message, $code, $previous);
        }
    }
}
