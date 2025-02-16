<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\UseCase;

use SlavaMakhov\OtusArchitectureApp\Domain\Factory\ConditionListFactoryInterface;
use SlavaMakhov\OtusArchitectureApp\Application\Gateway\QueueGatewayInterface;
use SlavaMakhov\OtusArchitectureApp\Domain\Factory\ConditionFactoryInterface;
use SlavaMakhov\OtusArchitectureApp\Application\Gateway\QueueGatewayRequest;
use SlavaMakhov\OtusArchitectureApp\Domain\Factory\EventFactoryInterface;

class SubmitEventUseCase
{
    /**
     * @param EventFactoryInterface $eventFactory
     * @param ConditionFactoryInterface $conditionFactory
     * @param ConditionListFactoryInterface $conditionListFactory
     * @param QueueGatewayInterface $queueGateway
     */
    public function __construct(
        private readonly EventFactoryInterface $eventFactory,
        private readonly ConditionFactoryInterface $conditionFactory,
        private readonly ConditionListFactoryInterface $conditionListFactory,
        private readonly QueueGatewayInterface $queueGateway
    )
    {
    }

    /**
     * @param SubmitEventRequest $request
     *
     * @return SubmitEventResponse
     */
    public function __invoke(SubmitEventRequest $request): SubmitEventResponse
    {
        foreach ($request->conditionList AS $name => $param) {
            $condition = $this->conditionFactory->create($name, $param);
            $this->conditionListFactory->add($condition);
        }
        $condition_list = $this->conditionListFactory->getList();
        $event = $this->eventFactory->create($request->priority, $request->name, $condition_list);

        $queueGatewayRequest = new QueueGatewayRequest($event);
        $queueGatewayResponse = $this->queueGateway->saveEvent($queueGatewayRequest);

        return new SubmitEventResponse($queueGatewayResponse->id);
    }
}
