<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\Gateway;

class QueueGatewayResponse
{
    /**
     * Метод DTO (Response) для очереди
     *
     * @param int $id
     */
    public function __construct(
        public readonly int $id
    )
    {
    }
}
