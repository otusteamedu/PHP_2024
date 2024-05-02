<?php

declare(strict_types=1);

use VictoriaBabikova\DbWorkerApp\Database\RowGateway\FilmFinder;

require __DIR__ . '/vendor/autoload.php';

$db = new PDO('pgsql:host=localhost;port=5432;dbname=Cinema', 'postgres', 'root');

$filmObj = new FilmFinder($db);

$film = $filmObj->findOneById(5);

$films = $filmObj->getAllFilms();

$film->setName("dracula 2");

$film->update(
    ["name" => $film->getName()]
);
