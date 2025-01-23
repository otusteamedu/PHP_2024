<?php

declare(strict_types=1);

namespace App;

use App\DB\DbConnection;

final class App
{
    public static function run(): void
    {
        $dbConnection = DbConnection::getInstance();

        $movieDirectorGateway = new MovieDirectorGateway();
        $movieGateway = new MovieGateway();

        $movieDirectors = $movieDirectorGateway->findAll();
        echo 'Movie Directors:' . PHP_EOL;
        self::printResult($movieDirectors);

        $movie = $movieGateway->findById(1);
        echo 'Movie By Id:' . PHP_EOL;
        self::printResult($movie);

        $movies = $movieGateway->findAll();
        echo 'All movies:' . PHP_EOL;
        self::printResult($movies);
    }

    public static function printResult(array $result): void
    {
        echo '<pre>';
        print_r($result);
        echo '</pre>' . PHP_EOL;
    }
}
