<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\Action;

use AlexanderGladkov\Analytics\Request\GetRequest;

class GetAction extends BaseAction
{
    public function run(array $args = []): Response
    {
        $request = GetRequest::createByArgs($args);
        $event = $this->eventRepository->find($request->getConditions());
        if ($event === null) {
            return new Response('Nothing is found!' . PHP_EOL);
        }

        return new Response($event->getValue() . PHP_EOL);
    }
}
