<?php

namespace PaymentServiceBundle\Controller\Amqp\Mailer;

use PaymentServiceBundle\Application\RabbitMq\AbstractConsumer;
use PaymentServiceBundle\Domain\Model\Email\EmailModel;
use PaymentServiceBundle\Domain\Service\Mailer;

class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly Mailer $mailer,
    ) {
    }

    protected function getMessageClass(): string
    {
        return Message::class;
    }

    /**
     * @param Message $message
     */
    protected function handle($message): int
    {
        $emailModel = new EmailModel(
            $message->uuid,
            $message->email,
            $message->emailSubject
        );

        $this->mailer->emailHandler($emailModel);

        return self::MSG_ACK;
    }
}
