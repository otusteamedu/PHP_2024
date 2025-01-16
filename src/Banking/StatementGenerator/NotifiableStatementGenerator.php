<?php

declare(strict_types=1);

namespace App\Banking\StatementGenerator;

use App\Banking\Notification\EmailNotification;
use App\Banking\Notification\NotificationTransportInterface;

final readonly class NotifiableStatementGenerator implements StatementGeneratorInterface
{
    public function __construct(
        private StatementGeneratorInterface $statementGenerator,
        private NotificationTransportInterface $notificationTransport,
    ) {}

    public function generate(GenerateStatementData $data): void
    {
        $this->statementGenerator->generate($data);

        // TODO: fetch user's data by user's ID ($data->userId)

        $userName = 'John Doe';
        $userEmail = 'johndoe@example.com';

        $notificationBody = sprintf(
            'Hey, %s! Requested statement has been generated.',
            $userName
        );

        $notification = new EmailNotification(
            from: 'noreply@example.com',
            to: $userEmail,
            body: $notificationBody,
        );

        $this->notificationTransport->send($notification);
    }
}
