<?php

declare(strict_types=1);

namespace App\Infrastructure\Consumer;

use App\Application\UseCase\GetStatementUseCase\GetStatementRequest;
use App\Application\UseCase\GetStatementUseCase\GetRequestUseCase;
use App\Application\UseCase\SendStatementUseCase\SendStatementRequest;
use App\Application\UseCase\SendStatementUseCase\SendStatementUseCase;
use App\Domain\Repository\RequestRepositoryInterface;
use App\Domain\ValueObject\Status;
use App\Infrastructure\Entity\StatusEnum;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

final class RequestConsumer implements ConsumerInterface
{
    public function __construct(
        private RequestRepositoryInterface $requestRepository
    ) {
    }

    public function execute(AMQPMessage $msg): bool
    {
        $msg = json_decode($msg->getBody());
        $request = $this->requestRepository->findById($msg->requestId);
        try {
            $request->setStatus(new Status(StatusEnum::Processing->value));
            $this->requestRepository->update($msg->requestId, $request);
            sleep(3);
            $processId = random_int(10_000, 99_999);
            if ($processId % 10 <= 2) {
                throw new \Exception('Failed to process request');
            }
            $request->setStatus(new Status(StatusEnum::Done->value));
            $this->requestRepository->update($msg->requestId, $request);
            return true;
        } catch (\Exception $exception) {
            $request->setStatus(new Status(StatusEnum::Error->value));
            $this->requestRepository->update($msg->requestId, $request);
            return false;
        }
    }
}
