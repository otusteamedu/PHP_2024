<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\Action;

use AlexanderGladkov\Analytics\Factory\EventEntityFactory;

class FillTestDataAction extends BaseAction
{
    public function run(array $args = []): Response
    {
        $this->eventRepository->deleteAll();
        $eventEntityFactory = new EventEntityFactory();
        foreach ($this->getEventsData() as $eventData) {
            $event = $eventEntityFactory->createByArray($eventData);
            $this->eventRepository->add($event);
        }

        return new Response('Success!' . PHP_EOL);
    }

    private function getEventsData(): array
    {
        return [
            [
                'priority' => 1000,
                'conditions' => [
                    'param1' => '1',
                ],
                'value' => 'event1',
            ],
            [
                'priority' => 2000,
                'conditions' => [
                    'param1' => '2',
                    'param2' => '2',
                ],
                'value' => 'event2',
            ],
            [
                'priority' => 3000,
                'conditions' => [
                    'param1' => '1',
                    'param2' => '2',
                ],
                'value' => 'event3',
            ],
        ];
    }
}
