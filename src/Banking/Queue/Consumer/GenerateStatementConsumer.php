<?php

declare(strict_types=1);

namespace App\Banking\Queue\Consumer;

use App\Banking\Queue\ConsumerInterface;
use App\Banking\Queue\MessageProcessFlag;
use App\Banking\StatementGenerator\GenerateStatementData;
use App\Banking\StatementGenerator\StatementGeneratorInterface;
use PhpAmqpLib\Message\AMQPMessage;

final readonly class GenerateStatementConsumer implements ConsumerInterface
{
    public function __construct(
        private StatementGeneratorInterface $statementGenerator,
    ) {}

    public function consume(AMQPMessage $message): MessageProcessFlag
    {
        $payload = json_decode($message->getBody(), true);

        $data = new GenerateStatementData(
            userId: (int) $payload['user_id'],
            dateFrom: new \DateTimeImmutable($payload['date_from']),
            dateTo: new \DateTimeImmutable($payload['date_to']),
        );

        try {
            $this->statementGenerator->generate($data);
        } catch (\Exception) {
            return MessageProcessFlag::REJECTED;
        }

        return MessageProcessFlag::ACKNOWLEDGED;
    }

    public function getQueueName(): string
    {
        return 'generate_statement_queue';
    }

    public function getExchangeName(): string
    {
        return 'generate_statement_exchange';
    }
}
