<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\UseCase;

class SubmitEventRequest
{
    /**
     * Метод DTO (Request) для Event
     *
     * @param int $priority
     * @param string $name
     * @param array $conditionList
     */
    public function __construct(
        public readonly int    $priority,
        public readonly string $name,
        public readonly array  $conditionList
    )
    {
    }
}
