<?php

declare(strict_types=1);

function insertMovie(PDO $pdo, $slug, $title, $duration)
{
    $sql = 'INSERT INTO movie (slug, title, duration) VALUES(:slug, :title, :duration)';
    $stmt = $pdo->prepare($sql);

    $stmt->bindValue(':slug', $slug);
    $stmt->bindValue(':title', $title);
    $stmt->bindValue(':duration', $duration);

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


function generateSessionTime(): string
{
    return sprintf('%02d-%02d-%d %02d:%02d:00.000000 +03', 2024, 03, rand(1, 31), rand(9, 21), rand(1, 11) * 5);
}
