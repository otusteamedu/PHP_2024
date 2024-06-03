<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Exception;

use Throwable;

class IncorrectJSONFormat extends BaseException
{
    protected const GENERATED_STATUS = 404;
    protected const MESSAGE = "НЕкорректный формат JSON";

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(IncorrectJSONFormat::MESSAGE,
            IncorrectJSONFormat::GENERATED_STATUS, $previous);
    }
}
