<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\RequestDTO\AddEventRequest;
use App\Application\ResponseDTO\EventResponse;
use App\Domain\Collection\ConditionCollection;
use App\Domain\Entity\Event;
use App\Domain\Repository\IRepository;
use App\Domain\ValueObject\Condition;
use App\Domain\ValueObject\Priority;

class AddEvent
{
    public function __construct(private IRepository $repository)
    {
    }

    public function __invoke(AddEventRequest $request): EventResponse
    {
        $conditionCollection = new ConditionCollection();
        foreach ($request->conditions as $paramName => $paramValue) {
            $conditionCollection->add(new Condition($paramName, $paramValue));
        }
        $priority = new Priority($request->priority);
        $event = new Event($priority, $conditionCollection);
        $event = $this->repository->add($event);
        return new EventResponse(
            $event->getUid()->getValue(),
            $event->getPriority()->getValue(),
            $event->getConditions()->toArray()
        );
    }
}
