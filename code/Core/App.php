<?php

namespace Core;

use App\Application\UseCase\SubmitEvent\SubmitEventUseCase;
use App\Infrastructure\Command\SubmitEventCommand;
use App\Infrastructure\Factory\CommonConditionListFactory;
use App\Infrastructure\Factory\CommonEventFactory;
use App\Application\UseCase\SubmitEvent\SubmitEventRequest;
use App\Infrastructure\Gateway\BetaRedisGateway;
use App\Infrastructure\Factory\CommonConditionFactory;
use Exception;

class App
{
    public function run()
    {
        $args = $_SERVER['argv'];

        switch ($args[1]) {
            case 'add': // '{"priority": 35000, "conditions": {"params1": 1}, "event": "Событие 3"}'
                $this->add($args[2]);
                break;
            case 'init':
//                $this->init();
            case 'search': // '{"params": {"params1":1,"params2":2}}'
//                $this->search($args[2]);
            case 'clear':
//                $this->clear();
            default:
                throw new Exception('Command not found');
        }
    }

    private function add(string $event_json = null)
    {
        $event_array = !empty($event_json) ? json_decode($event_json, true) : null;
        if (empty($event_array)) {
            throw new Exception('Error in event string');
        }

        $CommonEventFactory = new CommonEventFactory();
        $CommonConditionFactory = new CommonConditionFactory();
        $CommonConditionListFactory = new CommonConditionListFactory();
        $BetaRedisGateway = new BetaRedisGateway();
        $SubmitEventUseCase = new SubmitEventUseCase($CommonEventFactory,$CommonConditionFactory,$CommonConditionListFactory,$BetaRedisGateway);
        $SubmitEventCommand = new SubmitEventCommand($SubmitEventUseCase);
        $SubmitEventRequest = new SubmitEventRequest($event_array['priority'], $event_array['event'], $event_array['conditions']);
        $result = $SubmitEventCommand($SubmitEventRequest);
        var_dump("id in storage: ".$result->id);
    }

}