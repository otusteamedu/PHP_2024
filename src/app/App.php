<?php

declare(strict_types=1);

namespace App;

use App\DB\Seed;

class App
{
    /**
     * @throws \Exception
     */
    public static function run(): void
    {
        $seed = new Seed();

        // 10_000 билетов
        $seed->dbSeed();

//        // 100_000 билетов
//        $seed->dbSeed(100_000);

        $query = "SELECT * FROM movies";
        $stmt = (\App\DB\DbConnection::getInstance())->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
