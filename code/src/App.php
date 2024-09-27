<?php

declare(strict_types=1);

namespace IraYu\Hw12;

use IraYu\Hw12\Application\UseCase;
use IraYu\Hw12\Domain\Repository;
use IraYu\Hw12\Infrastructure\Repository\Redis;
use IraYu\Hw12\View\EventsView;
use PHPYurta\CLI\CLITable;

class App
{
    private Repository\EventRepositoryInterface $eventRepository;

    public function __construct(
        string $dbType,
        array $dbConnection,
    ) {
//        if ($dbType === 'redis' || true)
//        {
            $this->eventRepository = new Redis\EventRepository(
                Redis\ClientFactory::create(
                    host: $dbConnection['host'],
                    port: (int) $dbConnection['port'],
                    user: $dbConnection['user'],
                    password: $dbConnection['password'],
                    dbNumber: (int) $dbConnection['db_name'],
                )
            );
//        }
    }

    public function run(string $action, ?string $jsonParams = null): void
    {
        switch ($action) {
            case "save":
                (new UseCase\SaveEventFromJson(
                    new UseCase\Request\SaveEventFromJsonRequest(
                        eventRepository: $this->eventRepository,
                        jsonString: $jsonParams
                    )
                ))->run();

                echo 'Event has been saved.' . PHP_EOL;
                break;
            case "savelist":
                (new UseCase\SaveEventsFromJson(
                    new UseCase\Request\SaveEventFromJsonRequest(
                        eventRepository: $this->eventRepository,
                        jsonString: $jsonParams
                    )
                ))->run();
                echo 'Events have been saved.' . PHP_EOL;
                break;
            case "purge":
                (new UseCase\PurgeEvents(
                    new UseCase\Request\DefaultRequest(
                        eventRepository: $this->eventRepository,
                    )
                ))->run();
                echo 'Event storage has been cleared.' . PHP_EOL;
                break;
            case "find":
                $events = (new UseCase\FindEvents(
                    new UseCase\Request\FindEventsFromJsonRequest(
                        eventRepository: $this->eventRepository,
                        jsonString: $jsonParams,
                    )
                ))->run();
                if (empty($events)) {
                    echo 'There are no any results for: ' . $jsonParams . PHP_EOL;
                } else {
                    echo PHP_EOL . (new EventsView($events))->render() . PHP_EOL;
                }
                break;
        }
    }
}
