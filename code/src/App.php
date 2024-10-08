<?php

declare(strict_types=1);

namespace Irayu\Hw13;

use Irayu\Hw13\Domain;
use Irayu\Hw13\Infrastructure\Repository;

class App
{
    private Domain\Repository\CompetitionRepositoryInterface $competitionRepository;

    public function __construct(
        array $dbConnection,
    ) {


        $this->eventRepository = new Repository\Mysql\CompetitionRepository(
            new Repository\Mysql\CompetitionMapper(),
            Repository\Mysql\ClientFactory::create(
                host: $dbConnection['host'],
                port: (int) $dbConnection['port'],
                user: $dbConnection['user'],
                password: $dbConnection['password'],
                dbNumber: (int) $dbConnection['db_name'],
            )
        );
    }

    public function run(string $action, ?string $jsonParams = null): void
    {
        switch ($action) {
            case "find":
                $events = (new UseCase\FindEvents(
                    new UseCase\Request\FindEventsFromJsonRequest(
                        competitionRepository: $this->eventRepository,
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
