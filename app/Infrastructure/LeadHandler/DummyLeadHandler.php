<?php

namespace App\Infrastructure\LeadHandler;

use App\Application\LeadHandler\LeadHandlerInterface;
use App\Application\LeadHandler\LeadHandlerResult;
use App\Domain\Entity\Lead;

class DummyLeadHandler implements LeadHandlerInterface
{
    /**
     * @param Lead $lead
     * @return LeadHandlerResult
     * @throws \Exception
     */
    public function handle(Lead $lead): LeadHandlerResult
    {
        // имитируем обработку
        sleep(5);

        // случайным образом выбираем успешное или нет завершение обработки
        if (rand(0, 5) == 5) {
            throw new \Exception("Ошибка обработки заявки {$lead->getId()}");
        };

        return new LeadHandlerResult(
            status: Lead::STATUS_SUCCESS,
            sum:    rand(0, 1000),
            message: "Заявка {$lead->getId()} успешно обработана!"
        );
    }
}
