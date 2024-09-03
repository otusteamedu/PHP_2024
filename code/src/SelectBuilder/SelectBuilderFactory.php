<?php

declare(strict_types=1);

namespace Viking311\Builder\SelectBuilder;

use PDO;
use Viking311\Builder\Config\Config;
use Viking311\Builder\SelectBuilder\Strategy\LazyStrategy;
use Viking311\Builder\SelectBuilder\Strategy\StandardStrategy;

class SelectBuilderFactory
{
    private PDO $pdo;

    public function __construct()
    {
        $config = new Config();
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s',
            $config->host,
            $config->port,
            $config->dbName,
            $config->user,
            $config->password,
        );
        $this->pdo = new PDO($dsn);
    }

    /**
     * @return SelectBuilder
     */
    public function getSelectBuilder(): SelectBuilder
    {
        $strategy = new StandardStrategy();

        return new SelectBuilder(
            $this->pdo,
            $strategy
        );
    }

    /**
     * @return SelectBuilder
     */
    public function getLazySelectBuilder(): SelectBuilder
    {
        $strategy = new LazyStrategy();

        return new SelectBuilder(
            $this->pdo,
            $strategy
        );
    }
}
