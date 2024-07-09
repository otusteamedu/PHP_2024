<?php

declare(strict_types=1);

namespace App\Infrastructure\Database;

use PDO;
use App\Domain\Database\QueryInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

readonly class Query implements QueryInterface
{
    private PDO $pdo;

    public function __construct(private ParameterBagInterface $params)
    {
        $this->pdo = new PDO(
            $this->params->get('app.database_dsn'),
            $this->params->get('app.database_user'),
            $this->params->get('app.database_password'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function getNewsByUuid(string $uuid): array
    {
        $statement = $this->pdo->prepare(
            'SELECT * FROM news WHERE uuid_value = ?'
        );
        $statement->setFetchMode(PDO::FETCH_ASSOC);
        $statement->execute([$uuid]);

        return $statement->fetchAll();
    }
}
