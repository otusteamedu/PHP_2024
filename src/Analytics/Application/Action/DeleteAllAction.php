<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Application\Action;

class DeleteAllAction extends BaseAction
{
    public function run(array $args = []): Response
    {
        $this->eventRepository->deleteAll();
        return new Response('Success!' . PHP_EOL);
    }
}
