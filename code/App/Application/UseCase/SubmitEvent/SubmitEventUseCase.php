<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitEvent;

use App\Application\Gateway\RedisGatewayInterface;
use App\Application\Gateway\RedisGatewayRequest;
use App\Domain\Factory\ConditionFactoryInterface;
use App\Domain\Factory\ConditionListFactoryInterface;
use App\Domain\Factory\EventFactoryInterface;

class SubmitEventUseCase
{
    private EventFactoryInterface $eventFactory;
    private ConditionFactoryInterface $conditionFactory;
    private ConditionListFactoryInterface $conditionListFactory;
    private RedisGatewayInterface $redisGateway;
    public function __construct(
        EventFactoryInterface $eventFactory,
        ConditionFactoryInterface $conditionFactory,
        ConditionListFactoryInterface $conditionListFactory,
        RedisGatewayInterface $redisGateway
    )
    {
        $this->eventFactory = $eventFactory;
        $this->conditionFactory = $conditionFactory;
        $this->conditionListFactory = $conditionListFactory;
        $this->redisGateway = $redisGateway;
    }

    public function __invoke(SubmitEventRequest $request): SubmitEventResponse
    {
        foreach ($request->condition_list AS $name => $param) {
            $condition = $this->conditionFactory->create($name, $param);
            $this->conditionListFactory->add($condition);
        }
        $condition_list = $this->conditionListFactory->getList();
        $event = $this->eventFactory->create($request->priority, $request->name, $condition_list);

        $redisGatewayRequest = new RedisGatewayRequest($event);
        $redisGatewayResponse = $this->redisGateway->saveEvent($redisGatewayRequest);

        return new SubmitEventResponse(
            $redisGatewayResponse->id
        );
    }
}