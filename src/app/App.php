<?php

declare(strict_types=1);

namespace App;

use App\DB\DbConnection;

final class App
{
    public static function run(): void
    {
        $dbConnection = DbConnection::getInstance();

        $movieDirectorDataMapper = new MovieDirectorDataMapper();
        $movieDataMapper = new MovieDataMapper();

        $movieDirectors = $movieDirectorDataMapper->findAll();
        echo 'Movie Directors:' . PHP_EOL;
        self::printResult($movieDirectors);

        $movie = $movieDataMapper->findById(1);
        echo 'Movie By Id:' . PHP_EOL;
        self::printResult($movie);

        $movies = $movieDataMapper->findAll();
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
