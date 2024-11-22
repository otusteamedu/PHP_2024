<?php

$host = 'postgres';
$db = 'cinema_db';
$user = 'postgres';
$pass = 'postgres';
$port = '5432';

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Helper to generate random data
    function randomString($length = 10): string
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $length);
    }

    function randomDate($start, $end): string
    {
        $timestamp = mt_rand(strtotime($start), strtotime($end));

        return date("Y-m-d", $timestamp);
    }

    function generateRandomNumbers (int $from, int $to): int
    {
        return rand($from,$to);
    }

    // Insert data
    echo "Seeding data...\n";

    $raw10_000 = 10_000;
    $raw10_000_000 = 10_000_000;

    // Cinemas
    for ($i = 1; $i <= 100; $i++) {
        $pdo->exec("INSERT INTO Cinemas (name, location) VALUES ('Cinema_$i', 'Location_$i')");
    }

    // Halls
    for ($i = 1; $i <= $raw10_000; $i++) {
        $cinema_id = generateRandomNumbers(1, 100);
        $pdo->exec("INSERT INTO Halls (cinema_id, name, seat_count) VALUES ($cinema_id, 'Hall_$i', " . generateRandomNumbers(50, 200) . ")");
    }

    // Movies
    for ($i = 1; $i <= $raw10_000; $i++) {
        $title = "Movie_" . randomString(5);
        $duration = generateRandomNumbers(60, 180) . ' minutes';
        $genre = ['Action', 'Drama', 'Comedy', 'Horror'][array_rand(['Action', 'Drama', 'Comedy', 'Horror'])];
        $release_date = randomDate('2020-01-01', '2024-12-31');
        $pdo->exec("INSERT INTO Movies (title, duration, genre, release_date) VALUES ('$title', '$duration', '$genre', '$release_date')");
    }

    // Sessions
    for ($i = 1; $i <= $raw10_000; $i++) {
        $hall_id = generateRandomNumbers(1, $raw10_000);
        $movie_id = generateRandomNumbers(1, $raw10_000);
        $start_time = randomDate('2024-01-01', '2024-12-31') . " " . generateRandomNumbers(0, 23) . ":00:00";
        $price = generateRandomNumbers(5, 20) * 10;
        $pdo->exec("INSERT INTO Sessions (hall_id, movie_id, start_time, price) VALUES ($hall_id, $movie_id, '$start_time', $price)");
    }

    // Seats
    for ($i = 1; $i <= $raw10_000; $i++) {
        $hall_id = generateRandomNumbers(1, $raw10_000);
        $row = generateRandomNumbers(1, 20);
        $seat_number = generateRandomNumbers(1, 50);
        $pdo->exec("INSERT INTO Seats (hall_id, row, seat_number) VALUES ($hall_id, $row, $seat_number)");
    }

    // Tickets
    for ($i = 1; $i <= $raw10_000; $i++) {
        $session_id = generateRandomNumbers(1, $raw10_000);
        $seat_id = generateRandomNumbers(1, $raw10_000);
        $customer_name = "Customer_" . randomString(5);
        $price = generateRandomNumbers(5, 20) * 10;
        $pdo->exec("INSERT INTO Tickets (session_id, seat_id, customer_name, price) VALUES ($session_id, $seat_id, '$customer_name', $price)");
    }

    // TicketSales
    for ($i = 1; $i <= $raw10_000; $i++) {
        $ticket_id = generateRandomNumbers(1, $raw10_000);
        $sale_time = randomDate('2024-01-01', '2024-12-31') . " " . generateRandomNumbers(0, 23) . ":00:00";
        $total_amount = generateRandomNumbers(5, 20) * 10;
        $pdo->exec("INSERT INTO TicketSales (ticket_id, sale_time, total_amount) VALUES ($ticket_id, '$sale_time', $total_amount)");
    }

    echo "Seeding completed!\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}