<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Application\UseCase;

use SlavaMakhov\OtusArchitectureApp\Domain\Factory\ConditionListFactoryInterface;
use SlavaMakhov\OtusArchitectureApp\Application\Gateway\RedisGatewayInterface;
use SlavaMakhov\OtusArchitectureApp\Domain\Factory\ConditionFactoryInterface;
use SlavaMakhov\OtusArchitectureApp\Application\Gateway\RedisGatewayRequest;
use SlavaMakhov\OtusArchitectureApp\Domain\Factory\EventFactoryInterface;

class SubmitEventUseCase
{
    /**
     * @param EventFactoryInterface $eventFactory
     * @param ConditionFactoryInterface $conditionFactory
     * @param ConditionListFactoryInterface $conditionListFactory
     * @param RedisGatewayInterface $redisGateway
     */
    public function __construct(
        private readonly EventFactoryInterface $eventFactory,
        private readonly ConditionFactoryInterface $conditionFactory,
        private readonly ConditionListFactoryInterface $conditionListFactory,
        private readonly RedisGatewayInterface $redisGateway
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

        $redisGatewayRequest = new RedisGatewayRequest($event);
        $redisGatewayResponse = $this->redisGateway->saveEvent($redisGatewayRequest);

        return new SubmitEventResponse($redisGatewayResponse->id);
    }
}
