<?php

declare(strict_types=1);

namespace App\UseCase\GetEmailById;

use App\Entity\Email;
use App\Repository\EmailRepositoryInterface;

final readonly class GetEmailByIdUserCase
{
    public function __construct(
        private EmailRepositoryInterface $emailRepository,
    ) {}

    public function execute(string $emailId): ?Email
    {
        return $this->emailRepository->findOneById($emailId);
    }
}
