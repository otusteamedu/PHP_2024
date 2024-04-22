<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\Action;

use AlexanderGladkov\Analytics\Factory\EventEntityFactory;
use AlexanderGladkov\Analytics\Request\AddRequest;

class AddAction extends BaseAction
{
    public function run(array $args = []): Response
    {
        $request = AddRequest::createByArgs($args);
        $event = (new EventEntityFactory())->createByAddRequest($request);
        $this->eventRepository->add($event);
        return new Response('Success!' . PHP_EOL);
    }
}
