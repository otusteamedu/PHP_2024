<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\UseCase;

class SubmitEventResponse
{
    /**
     * Метод DTO (Response) для Event
     *
     * @param int $id
     */
    public function __construct(
        public readonly int $id
    )
    {
    }
}
