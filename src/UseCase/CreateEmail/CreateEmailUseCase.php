<?php

declare(strict_types=1);

namespace App\UseCase\CreateEmail;

use App\Entity\Email;
use App\Factory\EmailFactory;
use App\Repository\EmailRepositoryInterface;
use App\ValueObject\EmailStatus;
use Exception;
use Ramsey\Uuid\Uuid;

final readonly class CreateEmailUseCase
{
    public function __construct(
        private EmailFactory $emailFactory,
        private EmailRepositoryInterface $emailRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function execute(CreateEmailRequest $request): Email
    {
        $id = Uuid::uuid7()->toString();

        $email = $this->emailFactory->make(
            id: $id,
            status: EmailStatus::PENDING,
            from: $request->from,
            to: $request->to,
            text: $request->text
        );

        $this->emailRepository->save($email);

        return $email;
    }
}
