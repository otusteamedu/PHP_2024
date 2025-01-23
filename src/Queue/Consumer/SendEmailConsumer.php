<?php

declare(strict_types=1);

namespace App\Queue\Consumer;

use App\Exception\EmailNotFoundException;
use App\UseCase\SendEmail\SendEmailUseCase;
use Exception;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

final readonly class SendEmailConsumer implements ConsumerInterface
{
    public function __construct(
        private SendEmailUseCase $sendEmailUseCase,
    ) {}

    public function execute(AMQPMessage $msg): int
    {
        $data = json_decode($msg->getBody(), true);

        $emailId = $data['email_id'] ?? null;

        if (null === $emailId) {
            return self::MSG_REJECT;
        }

        try {
            $this->sendEmailUseCase->execute($emailId);
        } catch (EmailNotFoundException) {
            return self::MSG_REJECT;
        } catch (Exception) {
            return self::MSG_REJECT_REQUEUE;
        }

        return self::MSG_ACK;
    }
}
