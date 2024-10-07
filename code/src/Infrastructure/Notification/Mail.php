<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Notification;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Viking311\Queue\Application\Notification\NotificationInterface;
use Viking311\Queue\Domain\Entity\Event;

class Mail implements NotificationInterface
{
    const  string SUBJECT = 'Ваша заявка на проведение мероприятия обработана';
    const string TEMPLATE = 'Уважаемый %s<br>Ваша заявка на проведение мероприятия %s обработана';

    public function __construct(
        private readonly PHPMailer $mailer
    )
    {
    }

    /**
     * @throws Exception
     */
    public function send(Event $event): void
    {
        $this->mailer->addAddress(
            $event->getEmail()->getVaule(),
            $event->getName()->getValue()
        );
        $this->mailer->isHTML();
        $this->mailer->Subject = self::SUBJECT;
        $this->mailer->Body = sprintf(self::TEMPLATE, $event->getName()->getValue(), $event->getEventDate()->getValue()->format('Y-m-d H:i'));
        $this->mailer->send();
    }
}
