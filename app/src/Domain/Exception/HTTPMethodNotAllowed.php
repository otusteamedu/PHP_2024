<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Exception;

use Throwable;

class HTTPMethodNotAllowed extends BaseException
{
    protected const GENERATED_STATUS = 404;
    protected const MESSAGE = "Метод не поддерживается";

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(HTTPMethodNotAllowed::MESSAGE,
            HTTPMethodNotAllowed::GENERATED_STATUS, $previous);
    }
}
