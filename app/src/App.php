<?php

declare(strict_types=1);

namespace AnatolyShilyaev\Hw11;

use AnatolyShilyaev\Hw11\Connection;
use AnatolyShilyaev\Hw11\Movie;
use AnatolyShilyaev\Hw11\MovieMapper;

class App
{
    private MovieMapper $movieMapper;

    public function __construct()
    {
        $pdo = Connection::get()->connect();
        $this->movieMapper = new MovieMapper($pdo);
    }

    public function run(): void
    {
        try {
            //Добавление нового фильма
            $newMovie = new Movie(null, "Троя2");
            $newMovieId = $this->movieMapper->insert($newMovie);
            echo "<br>";
            echo $newMovieId;
            echo "<br><br>";

            //Получение всех фильмов
            $movies = $this->movieMapper->findAll(10, rand(1, 9000000));
            echo "<table border=1 cellspacing=0>";
            echo "<thead>";
            echo "<tr>";
            echo "<td>Movie ID</td>";
            echo "<td>Movie Name</td>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach ($movies as $movie) {
                echo "<tr>";
                echo "<td>";
                echo $movie->getId() . "\n";
                echo "</td>";
                echo "<td>";
                echo $movie->getName() . "\n";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            echo "<br><br>";

            //Получение фильма по ID
            $movie = $this->movieMapper->find($newMovieId);
            echo 'Movie Name: ' . $movie->getName() . "<br>";

            //Обновление наименование фильма
            $isUpdate = $this->movieMapper->update($movie, "Одиссея");

            if ($isUpdate) {
                //Получение обновленного фильма по ID
                $movie = $this->movieMapper->find($newMovieId);
                echo 'New Name: ' . $movie->getName() . "<br>";
            } else {
                echo "UPDATE ERROR";
            }

            //Удаление фильма
            $this->movieMapper->delete($newMovieId);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}
