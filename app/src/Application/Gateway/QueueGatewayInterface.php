<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\Gateway;

interface QueueGatewayInterface
{
    /**
     * Метод добавляет Event в очередь
     *
     * @param QueueGatewayRequest $request
     *
     * @return QueueGatewayResponse
     */
    public function saveEvent(QueueGatewayRequest $request): QueueGatewayResponse;
}
