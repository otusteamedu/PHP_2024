<?php

declare(strict_types=1);

namespace App\Rabbitmq\Consumer;

use App\Rabbitmq\Message\BankReportMessage;
use App\Service\MailerService;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Psr\Log\LoggerInterface;

class BankReportConsumer implements ConsumerInterface
{
    public function __construct(
        private readonly MailerService $mailerService,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function execute(AMQPMessage $msg): bool|int
    {
        try {
            $data = json_decode($msg->body, true, flags: JSON_THROW_ON_ERROR);

            if ($data['className'] !== BankReportMessage::class) {
                $this->logger->error(sprintf('Unsupported message class: %s', $data['className']));

                return false;
            }

            echo sprintf('Received bank report message: %s', $msg->body) . PHP_EOL;

            $message = BankReportMessage::createFromArray($data);
            $this->mailerService->sendEmail($message);

            return self::MSG_ACK;
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [ 'exception' => $e ]);

            return self::MSG_REJECT;
        }
    }
}
