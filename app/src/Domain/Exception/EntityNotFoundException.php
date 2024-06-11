<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Exception;

use Throwable;

class EntityNotFoundException extends BaseException
{
    protected const GENERATED_STATUS = 404;
    protected const MESSAGE = "Данные не найдены";

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            EntityNotFoundException::MESSAGE,
            EntityNotFoundException::GENERATED_STATUS,
            $previous
        );
    }
}
