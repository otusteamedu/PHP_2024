<?php

declare(strict_types=1);

namespace App\Banking\Queue\Publisher;

use App\Banking\Queue\AbstractPublisher;
use App\Banking\Queue\PublisherInterface;

final readonly class GenerateStatementPublisher extends AbstractPublisher implements PublisherInterface
{
    public function getQueueName(): string
    {
        return 'generate_statement_queue';
    }

    public function getExchangeName(): string
    {
        return 'generate_statement_exchange';
    }
}
