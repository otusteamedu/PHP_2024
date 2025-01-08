<?php

require_once 'vendor/autoload.php';

use Faker\Factory;

$host = 'postgres';
$dbname = 'cinema';
$user = 'postgres';
$password = 'changeme';

$dsn = "pgsql:host=$host;dbname=$dbname";
$pdo = new PDO($dsn, $user, $password);
$faker = Factory::create('ru_RU');

// 1. Заполнение таблицы seat_type
function generateSeatTypes($pdo) {
    $seatTypes = ['Стандартное', 'VIP', 'Эконом'];
    $stmt = $pdo->prepare("INSERT INTO seat_type (name) VALUES (:name)");

    foreach ($seatTypes as $type) {
        $stmt->execute(['name' => $type]);
    }
}

// 2. Заполнение таблицы hall
function generateHalls($pdo, $faker, $count = 20) {
    $stmt = $pdo->prepare("INSERT INTO hall (name) VALUES (:name)");

    for ($i = 1; $i <= $count; $i++) {
        $name = $faker->unique()->word;
        $stmt->execute(['name' => ucfirst($name)]);
    }
}

// 3. Заполнение таблицы seat
function generateSeats($pdo, $hallCount, $rows = 20, $cols = 25, $seatTypeCount = 3) {
    $stmt = $pdo->prepare("INSERT INTO seat (hall_id, horizont, vertical, seat_type_id) 
                           VALUES (:hall_id, :horizont, :vertical, :seat_type_id)");

    for ($hallId = 1; $hallId <= $hallCount; $hallId++) {
        for ($row = 1; $row <= $rows; $row++) {
            for ($col = 1; $col <= $cols; $col++) {
                $stmt->execute([
                    'hall_id' => $hallId,
                    'horizont' => $row,
                    'vertical' => $col,
                    'seat_type_id' => rand(1, $seatTypeCount)
                ]);
            }
        }
    }
}

// 4. Заполнение таблицы movie
function generateMovies($pdo, $faker, $count = 1000) {
    $stmt = $pdo->prepare("INSERT INTO movie (name, duration) VALUES (:name, :duration)");

    for ($i = 0; $i < $count; $i++) {
        $name = $faker->sentence(2);
        $duration = $faker->numberBetween(90, 150);
        
        $stmt->execute([
            'name' => $name,
            'duration' => "{$duration} minutes"
        ]);
    }
}

// 5. Заполнение таблицы session
function generateSessions($pdo, $faker, $movieCount, $hallCount, $count = 5000) {
    $stmt = $pdo->prepare("INSERT INTO session (movie_id, hall_id, start, finish) 
                           VALUES (:movie_id, :hall_id, :start, :finish)");

    for ($i = 0; $i < $count; $i++) {
        $hallId = $faker->numberBetween(1, $hallCount);
        $movieId = $faker->numberBetween(1, $movieCount);

        // Проверяем существующие сеансы для этого зала
        $existingSessionsStmt = $pdo->prepare("
            SELECT start, finish 
            FROM session 
            WHERE hall_id = :hall_id
        ");
        $existingSessionsStmt->execute(['hall_id' => $hallId]);
        $existingSessions = $existingSessionsStmt->fetchAll(PDO::FETCH_ASSOC);

        do {
            $start = $faker->dateTimeBetween('-100 week', '+4 week');
            $duration = $faker->numberBetween(60, 180);
            $finish = (clone $start)->modify("+$duration minutes");

            $isOverlapping = false;

            foreach ($existingSessions as $session) {
                $existingStart = new DateTime($session['start']);
                $existingFinish = new DateTime($session['finish']);

                // Проверяем пересечение интервалов
                if ($start < $existingFinish && $finish > $existingStart) {
                    $isOverlapping = true;
                    break;
                }
            }
        } while ($isOverlapping);

        $stmt->execute([
            'movie_id' => $movieId,
            'hall_id' => $hallId,
            'start' => $start->format('Y-m-d H:i:s'),
            'finish' => $finish->format('Y-m-d H:i:s')
        ]);
    }
}

// 6. Заполнение таблицы price
function generatePrices($pdo, $faker, $sessionCount, $seatTypeCount) {
    $stmt = $pdo->prepare("INSERT INTO price (session_id, seat_type_id, value) 
                           VALUES (:session_id, :seat_type_id, :value)
                           ON CONFLICT (session_id, seat_type_id) DO NOTHING");

    for ($sessionId = 1; $sessionId <= $sessionCount; $sessionId++) {
        for ($seatTypeId = 1; $seatTypeId <= $seatTypeCount; $seatTypeId++) {
            $value = $faker->randomElement([300, 500, 700, 900, 1100]);
            $stmt->execute([
                'session_id' => $sessionId,
                'seat_type_id' => $seatTypeId,
                'value' => $value
            ]);
        }
    }
}

// 7. Заполнение таблицы ticket
function generateTickets($pdo, $faker, $sessionCount, $seatCount, $ticketCount = 100000, $batchSize = 1000) {
    $pdo->beginTransaction();
    $insertQuery = "INSERT INTO ticket (session_id, seat_id, price, discount_percent, is_sold) VALUES ";
    $placeholders = [];
    $params = [];

    for ($i = 0; $i < $ticketCount; $i++) {
        $sessionId = $faker->numberBetween(1, $sessionCount);
        $seatId = $faker->numberBetween(1, $seatCount);
        $price = $faker->randomElement([300, 500, 700, 900, 1100]);
        $discountPercent = $faker->randomElement([0, 10, 20, 50]);
        $isSold = $faker->boolean(70) ? 'true' : 'false';

        $placeholders[] = "(?, ?, ?, ?, ?)";
        $params[] = $sessionId;
        $params[] = $seatId;
        $params[] = $price;
        $params[] = $discountPercent;
        $params[] = $isSold;

        if (count($placeholders) === $batchSize) {
            $pdo->prepare($insertQuery . implode(", ", $placeholders) . " ON CONFLICT (session_id, seat_id) DO NOTHING")
                ->execute($params);

            $placeholders = [];
            $params = [];
        }
    }

    if (!empty($placeholders)) {
        $pdo->prepare($insertQuery . implode(", ", $placeholders) . " ON CONFLICT (session_id, seat_id) DO NOTHING")
            ->execute($params);
    }

    $pdo->commit();
}


generateSeatTypes($pdo);

generateHalls($pdo, $faker, 8); // 8 залов

generateSeats($pdo, 8, 10, 10, 3); // 8 залов, 30 рядов, 25 мест в ряду, 3 типа мест

generateMovies($pdo, $faker, 1000); // 1000 фильмов

generateSessions($pdo, $faker, 1000, 8, 20000); // 1000 фильмов, 8 залов, 20000 сеансов

generatePrices($pdo, $faker, 20000, 3); // 20000 сеансов, 3 типа мест

generateTickets($pdo, $faker, 20000, 800, 10000000); // 20000 сеансов, 800 мест, 10000000 билетов

echo "Данные успешно сгенерированы!";
