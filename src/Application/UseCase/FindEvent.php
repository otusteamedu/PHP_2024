<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\RequestDTO\FindEventRequest;
use App\Application\ResponseDTO\EventResponse;
use App\Domain\Collection\ConditionCollection;
use App\Domain\Repository\IRepository;
use App\Domain\ValueObject\Condition;
use Exception;

class FindEvent
{
    public function __construct(private IRepository $repository)
    {
    }

    public function __invoke(FindEventRequest $request): EventResponse
    {
        $conditionCollection = new ConditionCollection();
        foreach ($request->conditions as $paramName => $paramValue) {
            $conditionCollection->add(new Condition($paramName, $paramValue));
        }

        $event = $this->repository->findEvent($conditionCollection);
        if (empty($event)) {
            throw new Exception('Event not found');
        }
        return new EventResponse(
            $event->getUid()->getValue(),
            $event->getPriority()->getValue(),
            $event->getConditions()->toArray()
        );
    }
}
