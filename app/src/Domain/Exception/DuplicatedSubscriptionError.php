<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Exception;

use Throwable;

class DuplicatedSubscriptionError extends BaseException
{
    protected const GENERATED_STATUS = 404;
    protected const MESSAGE = "Подписка уже существует";

    public function __construct(Throwable $previous = null)
    {
        parent::__construct(
            DuplicatedSubscriptionError::MESSAGE,
            DuplicatedSubscriptionError::GENERATED_STATUS,
            $previous
        );
    }
}
