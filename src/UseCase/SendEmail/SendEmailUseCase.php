<?php

declare(strict_types=1);

namespace App\UseCase\SendEmail;

use App\EmailSender\EmailSenderInterface;
use App\Exception\EmailNotFoundException;
use App\Exception\EmailSenderException;
use App\Repository\EmailRepositoryInterface;
use App\ValueObject\EmailStatus;
use Exception;

final readonly class SendEmailUseCase
{
    public function __construct(
        private EmailRepositoryInterface $emailRepository,
        private EmailSenderInterface $emailSender,
    ) {}

    /**
     * @throws EmailNotFoundException
     * @throws EmailSenderException
     * @throws Exception
     */
    public function execute(string $emailId): void
    {
        $email = $this->emailRepository->findOneById($emailId);

        if ($email === null) {
            throw new EmailNotFoundException('Email not found');
        }

        $email->status = EmailStatus::SENDING;

        $this->emailRepository->save($email);

        $this->emailSender->send($email);

        $email->status = EmailStatus::SENT;

        $this->emailRepository->save($email);
    }
}
