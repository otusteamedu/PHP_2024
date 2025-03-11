<?php

declare(strict_types=1);

namespace Otus\Hw20\Application\UseCase;

use Otus\Hw20\Application\Message\GenerateStatementMessage;
use Otus\Hw20\Domain\Entity\StatementRequest;
use Otus\Hw20\Domain\Repository\StatementRequestRepositoryInterface;
use Otus\Hw20\Domain\ValueObject\DateRange;
use Symfony\Component\Messenger\MessageBusInterface;

class RequestStatementUseCase
{
    public function __construct(
        private StatementRequestRepositoryInterface $repository,
        private MessageBusInterface $messageBus
    ) {}

    public function execute(\DateTimeInterface $startDate, \DateTimeInterface $endDate): StatementRequest
    {
        $dateRange = new DateRange($startDate, $endDate);
        $request = new StatementRequest($dateRange);
        $this->repository->save($request);
        $this->messageBus->dispatch(new GenerateStatementMessage($request->getId()));
        return $request;
    }
}
