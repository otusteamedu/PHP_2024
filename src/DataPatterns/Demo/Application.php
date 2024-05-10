<?php

declare(strict_types=1);

namespace AlexanderGladkov\DataPatterns\Demo;

use AlexanderGladkov\DataPatterns\Config\Config;
use AlexanderGladkov\DataPatterns\DataMapper\GenreDataMapper;
use AlexanderGladkov\DataPatterns\DataMapper\MovieDataMapper;
use AlexanderGladkov\DataPatterns\DB\PDOFactory;
use AlexanderGladkov\DataPatterns\Entity\Movie;
use AlexanderGladkov\DataPatterns\Entity\Genre;
use DateTime;
use PDO;

class Application
{
    public function run()
    {
        $config = new Config();
        $pdo = $this->getPDO($config);
        $movieDataMapper = new MovieDataMapper($pdo);
        $genreDataMapper = new GenreDataMapper($pdo);

        $movies = $movieDataMapper->findAll();
        foreach ($movies as $movie) {
            $movieDataMapper->delete($movie->getId());
        }

        $genres = $genreDataMapper->findAll();
        foreach ($genres as $genre) {
            $genreDataMapper->delete($genre->getId());
        }

        $genreNames = ['Боевик', 'Фантастика', 'Триллер'];
        foreach ($genreNames as $genreName) {
            $genre = new Genre($genreName);
            $genreDataMapper->insert($genre);
        }

        $genres = $genreDataMapper->findAll();
        $movie = new Movie('Терминатор', DateTime::createFromFormat('Y-m-d', '1984-10-26'), 108);
        $movieDataMapper->insert($movie);
        $movieDataMapper->updateGenres($movie, $genres);

        $movie->setDescription('История противостояния солдата Кайла Риза и киборга-терминатора, прибывших в 1984 год');
        $movieDataMapper->update($movie);

        $movie = $movieDataMapper->findAll()[0];
        echo $this->getOutput($movie);
    }

    private function getPDO(Config $config): PDO
    {
        return (new PDOFactory())->create(
            $config->getDbHost(),
            $config->getDbPort(),
            $config->getDbName(),
            $config->getDbUser(),
            $config->getDbPassword()
        );
    }

    private function getOutput(Movie $movie): string
    {
        $output = '<pre>';
        $output .= '-----------------------Фильм-----------------------<br>';
        $output .= $this->getMovieView($movie);
        $output .= '-----------------------Жанры-----------------------<br>';
        foreach ($movie->getGenres() as $genre) {
            $output .= $this->getGenreView($genre);
        }
        $output .= '---------------------------------------------------<br>';
        $output .= '</pre>';

        return $output;
    }

    private function getMovieView(?Movie $movie): string
    {
        if ($movie === null) {
            return 'NULL';
        }

        return print_r([
            'id' => $movie->getId(),
            'title' => $movie->getTitle(),
            'releaseDate' => $movie->getReleaseDate()->format('Y-m-d'),
            'duration' => $movie->getDuration(),
            'description' => $movie->getDescription(),
        ], true);
    }

    private function getGenreView(?Genre $genre): string
    {
        if ($genre === null) {
            return 'NULL';
        }

        return print_r([
            'id' => $genre->getId(),
            'name' => $genre->getName(),
        ], true);
    }
}
