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
        // 10_000 билетов
        (new Seed)->DbSeed();

//        // 100_000 билетов
//        (new Seed)->DbSeed(100_000);

        $query = "SELECT * FROM movies";
        $stmt = (\App\DB\DbConnection::getInstance())->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}
