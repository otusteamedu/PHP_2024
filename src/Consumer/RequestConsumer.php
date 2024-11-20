<?php

declare(strict_types=1);

namespace App\Consumer;

use App\Repository\RequestRepository;
use App\ValueObject\StatusValueObject;

readonly class RequestConsumer
{
    public function __construct(private RequestRepository $requestRepository)
    {
    }

    public function consume(string $msg): void
    {
        $params = json_decode($msg, true);
        $requestId = $params['id'] ?? null;
        if ($requestId !== null && $requestEntity = $this->requestRepository->finById($requestId)) {
            $requestEntity->setStatus(StatusValueObject::Processing);
            $this->requestRepository->updateRequestStatus($requestEntity);
            sleep(5); // Симуляция обработки
            $requestEntity->setStatus(StatusValueObject::Completed);
            $this->requestRepository->updateRequestStatus($requestEntity);
        }
    }
}
