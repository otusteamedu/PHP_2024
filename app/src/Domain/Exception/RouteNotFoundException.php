<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Exception;

use Throwable;

class RouteNotFoundException extends BaseException
{
    protected const GENERATED_STATUS = 404;
    protected const MESSAGE = "Метод не поддерживается";

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(RouteNotFoundException::MESSAGE,
            RouteNotFoundException::GENERATED_STATUS, $previous);
    }
}
