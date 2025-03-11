<?php

declare(strict_types=1);

namespace Otus\Hw20\Application\Message;

class GenerateStatementMessage
{
    public function __construct(private int $requestId)
    {
    }

    public function getRequestId(): int
    {
        return $this->requestId;
    }
}
