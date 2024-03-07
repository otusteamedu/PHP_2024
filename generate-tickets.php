<?php

declare(strict_types=1);

require __DIR__ . '/utils.php';

const MOVIE_POOL = [
    [
        'slug' => 'korol-liev',
        'title' => 'Король лев',
        'duration' => 7200
    ],
    [
        'slug' => 'batman',
        'title' => 'Бэтмен',
        'duration' => 7200
    ],
    [
        'slug' => 'titanik',
        'title' => 'Титаник',
        'duration' => 7200
    ],
];
const HALL_POOL = [
    'A' => [
        'nick' => 'A',
        'number_of_rows' => 12,
        'number_of_seats_per_row' => 15,
    ],
    'B' => [
        'nick' => 'B',
        'number_of_rows' => 10,
        'number_of_seats_per_row' => 15,
    ],
    'C' => [
        'nick' => 'C',
        'number_of_rows' => 10,
        'number_of_seats_per_row' => 10,
    ],
    'XL' => [
        'nick' => 'XL',
        'number_of_rows' => 15,
        'number_of_seats_per_row' => 20,
    ],
];

$dsnStr = sprintf(
    "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
    'localhost',
    '5432',
    'hukimato',
    'hukimato',
    'hukimato',
);

$dbh = new PDO($dsnStr);

foreach (MOVIE_POOL as $movie) {
    insertMovie($dbh, $movie['slug'], $movie['title'], $movie['duration']);
}

foreach (HALL_POOL as $hall) {
    insertHall($dbh, $hall['nick'], $hall['number_of_rows'], $hall['number_of_seats_per_row']);
}

$insertedSessionsIds = [];
for ($i = 0; $i < 100; $i++) {
    $movie = MOVIE_POOL[array_rand(MOVIE_POOL)];
    $hall = HALL_POOL[array_rand(HALL_POOL)];
    $session_ts = generateSessionTime();
    $id = insertRandomSession($dbh, $movie['slug'], $hall['nick'], $session_ts, $session_ts = generateSessionTime(), rand(1, 40) * 50);
}

$sessions = getSessionsData($dbh);

for ($i = 0; $i < 200; $i++) {
    $session = $sessions[array_rand($sessions)];
    insertRandomTicket($dbh, $session['id'], rand(1, $session['number_of_rows']), rand(1, $session['number_of_seats_per_row']));
}

