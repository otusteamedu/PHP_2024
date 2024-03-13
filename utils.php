<?php

declare(strict_types=1);

function insertCountries(PDO $pdo, $name)
{
    $sql = 'INSERT INTO country (name) VALUES(:name)';
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':name', $name);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function insertGenre(PDO $pdo, $name)
{
    $sql = 'INSERT INTO genre (name) VALUES(:name)';
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':name', $name);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function randomiseGenresToFilms(PDO $pdo)
{
    $sth = $pdo->query('SELECT id FROM genre');
    $genres = $sth->fetchAll(PDO::FETCH_ASSOC);

    $sth = $pdo->query('SELECT id FROM movie');
    $movies = $sth->fetchAll(PDO::FETCH_ASSOC);

    $sql = 'INSERT INTO genre_movie (genre_id, movie_id) VALUES(:genre_id, :movie_id)';
    $stmt = $pdo->prepare($sql);

    foreach ($movies as $movie) {
        shuffle($genres);
        $genresPool = array_slice($genres, 0, rand(0, rand(1, 5)));
        foreach ($genresPool as $genre) {
            echo $genre['id'] . '-' . $movie['id'] . PHP_EOL;
            $stmt->bindValue(':genre_id', $genre['id']);
            $stmt->bindValue(':movie_id', $movie['id']);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
}

function insertMovie(PDO $pdo, $country, $title, $duration, $creation_year)
{
    $sql = 'INSERT INTO movie (title, country, duration, creation_year) VALUES(:title, :country, :duration, :creation_year)';
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':country', $country);
    $stmt->bindValue(':duration', $duration);
    $stmt->bindValue(':creation_year', $creation_year);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function insertHall(PDO $pdo, $nick, $number_of_rows, $number_of_seats_per_row)
{
    $sql = 'INSERT INTO hall (nick, number_of_rows, number_of_seats_per_row) VALUES(:nick, :number_of_rows, :number_of_seats_per_row)';
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':nick', $nick);
    $stmt->bindValue(':number_of_rows', $number_of_rows);
    $stmt->bindValue(':number_of_seats_per_row', $number_of_seats_per_row);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

/**
 * @param PDO $pdo
 * @param $session_id
 * @param $row
 * @param $seat
 * @return false|string
 */
function insertRandomTicket(PDO $pdo, $session_id, $row, $seat)
{
    $sql = 'INSERT INTO ticket (session_id, row, seat) VALUES(:session_id, :row, :seat)';
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':session_id', $session_id);
    $stmt->bindValue(':row', $row);
    $stmt->bindValue(':seat', $seat);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    // return generated id
    return $pdo->lastInsertId();
}

/**
 * @param PDO $pdo
 * @param $movie
 * @param $hall
 * @param $start_ts
 * @param $ticket_cost
 * @return false|string
 */
function insertRandomSession(PDO $pdo, $movie, $hall, $start_ts, $end_ts, $ticket_cost)
{
    if (!validateSessionDuration($pdo, $start_ts, $end_ts, $movie) || !validateSessionIntersection($pdo, $start_ts, $end_ts)) {
        return false;
    }

    $sql = 'INSERT INTO session (movie, hall, start_ts, end_ts, ticket_cost) VALUES (:movie, :hall, :start_ts, :end_ts, :ticket_cost)';
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':movie', $movie);
    $stmt->bindValue(':hall', $hall);
    $stmt->bindValue(':start_ts', $start_ts);
    $stmt->bindValue(':end_ts', $end_ts);
    $stmt->bindValue(':ticket_cost', $ticket_cost);

    try {
        $stmt->execute();
        return $pdo->lastInsertId();
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

function getSessionsData(PDO $pdo)
{
    $sth = $pdo->query('SELECT id, h.nick, h.number_of_rows, h.number_of_seats_per_row FROM session
JOIN hall as h
ON session.hall = h.nick');
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

function getMoviesData(PDO $pdo)
{
    $sth = $pdo->query('SELECT id FROM movie');
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

function getCountriesData(PDO $pdo)
{
    $sth = $pdo->query('SELECT id FROM country');
    return $sth->fetchAll(PDO::FETCH_ASSOC);
}

function generateSessionTime(): string
{
    return sprintf('%02d-%02d-%d %02d:%02d:00.000000 +03', 2024, 03, rand(1, 31), rand(9, 21), rand(1, 11) * 5);
}

function validateSessionDuration(PDO $pdo, $start_ts, $end_ts, $movie_id)
{
    $sth = $pdo->prepare('SELECT movie.duration from movie where id = ?');
    $sth->execute([$movie_id]);
    $movieDuration = $sth->fetch()['duration'];

    return strtotime($end_ts) - strtotime($start_ts) >= $movieDuration * 60;
}

function validateSessionIntersection(PDO $pdo, $start_ts, $end_ts)
{
    $sth = $pdo->prepare('SELECT id from session
                    WHERE (start_ts < :start_ts AND end_ts > :end_ts)
                       OR (start_ts > :start_ts AND end_ts < :end_ts)');
    $sth->execute(['start_ts' => $start_ts, 'end_ts' => $end_ts]);
    return $sth->rowCount() == 0;
}
