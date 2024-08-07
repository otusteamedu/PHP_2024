<?php

namespace App;

use App\Connections\DatabaseConnection;
use App\Core\Config;
use PDO;

final class App
{
    public static self $app;

    public DatabaseConnection $connection;

    public function __construct()
    {
        $this->prepareConnection();

        self::$app = $this;
    }

    public function run(): void
    {

    }

    private function prepareConnection(): void
    {
        $this->connection = new DatabaseConnection();
    }
}