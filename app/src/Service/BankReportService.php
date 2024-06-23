<?php

declare(strict_types=1);

namespace App\Service;

use App\Rabbitmq\Message\BankReportMessage;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class BankReportService
{
    public function __construct(private readonly ProducerInterface $producer)
    {
    }

    /**
     * @throws \JsonException
     */
    public function publish(BankReportMessage $message): void
    {
        $json = json_encode($message, JSON_THROW_ON_ERROR);
        $this->producer->publish($json);
    }
}
