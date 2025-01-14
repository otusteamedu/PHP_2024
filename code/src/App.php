<?php

declare(strict_types=1);

namespace Otus\DbPattern;

use Otus\DbPattern\DbMapper\MovieMapper;
use Otus\DbPattern\Models\Movie;

class App
{
    private MovieMapper $movieMapper;

    public function __construct()
    {
        $pdo = (new Entry())->getPdo();
        $this->movieMapper = new MovieMapper($pdo);
    }

    /**
     * @return void
     */
    public function run(): void
    {
        // Пример создания новой записи
        $newMovie = new Movie(
            null,
            'Mission impossible',
            '2025-01-01',
            '2025-12-31',
            500
        );
        $newMovieId = $this->movieMapper->insert($newMovie);

        // Пример получения всех записей
        $movies = $this->movieMapper->findAll();
        foreach ($movies as $movie) {
            echo 'All movies: ' . PHP_EOL;
            var_dump($movie);
        }

        // Пример получения записи по ID
        $movie = $this->movieMapper->find($newMovieId);
        echo 'Movie title: ' . $movie->getTitle() . PHP_EOL;

        // Пример обновления записи
        $movie->setTitle('Mission possible');
        $this->movieMapper->update($movie);
        echo 'Movie new title: ' . $movie->getTitle() . PHP_EOL;

        // Пример удаления записи
        $this->movieMapper->delete($newMovieId);
        echo 'end' . PHP_EOL;
    }
}
