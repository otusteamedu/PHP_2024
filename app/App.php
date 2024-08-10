<?php

namespace App;

use App\Connections\DatabaseConnection;
use App\Entities\User;
use App\Mappers\OrderMapper;
use App\Mappers\UserMapper;
use Exception;

final class App
{
    public static self $app;

    public DatabaseConnection $db;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->prepareConnection();
        $this->registerMappers();

        self::$app = $this;
    }

    public function run(): void
    {
    }

    private function prepareConnection(): void
    {
        $this->db = new DatabaseConnection();
    }

    /**
     * @throws Exception
     */
    private function registerMappers(): void
    {
        UserMapper::initialize($this->db);
        OrderMapper::initialize($this->db);
    }
}
