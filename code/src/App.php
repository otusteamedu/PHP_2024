<?php

declare(strict_types=1);

namespace Irayu\Hw13;

use Irayu\Hw13\Domain;
use Irayu\Hw13\Infrastructure\Repository;
use Irayu\Hw13\Application\UseCase;
use Irayu\Hw13\UI;

class App
{
    private Repository\IdentityMap $identityMap;
    private Domain\Repository\CompetitionRepositoryInterface $competitionRepository;

    public function __construct(
        array $dbConnection,
    ) {
        $client = Repository\Mysql\ClientFactory::create(
            host: $dbConnection['host'],
            port: (int) $dbConnection['port'],
            user: $dbConnection['user'],
            password: $dbConnection['password'],
            dbName: $dbConnection['db_name'],
        );
        $this->identityMap = new Repository\IdentityMap();

        $this->competitionRepository = new Repository\Mysql\CompetitionRepository(
            $client,
            new Repository\Mysql\Mapper\CompetitionMapper($client),
            $this->identityMap,
        );
    }

    public function run(string $action, ?string $jsonParams = null): void
    {
        switch ($action) {
            case "find":
                $competitions = (new UseCase\FindCompetitions(
                    new UseCase\Request\FindCompetitionsRequest(
                        competitionRepository: $this->competitionRepository,
                        filterJson: $jsonParams,
                    )
                ))->run()->competitions;

                if (empty($competitions)) {
                    echo 'There are no any results for: ' . $jsonParams . PHP_EOL;
                } else {
                    echo PHP_EOL . (new UI\View\CompetitionView($competitions))->render() . PHP_EOL;
                }
                break;
        }
    }
}
