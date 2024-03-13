<?php

declare(strict_types=1);

require __DIR__ . '/utils.php';

const GENRES = [
    'Action',
    'Adventure',
    'Animation',
    'Comedy',
    'Crime',
    'Documentary',
    'Drama',
    'Family',
    'Fantasy',
    'Film-Noir',
    'History',
    'Horror',
    'Music',
    'Musical',
    'Mystery',
    'Romance',
    'Sci-Fi',
    'Thriller',
    'War',
    'Western'
];

const COUNTRIES = [
    'USA', 'Russia', 'China', 'Japan', 'Germany', 'France',
];

const MOVIE_POOL = [
    [
        'slug' => 'korol-liev',
        'title' => 'Король лев',
        'duration' => 7200,
        'country' => 'Russia',
        'creation_year' => 2021
    ],
    [
        'slug' => 'batman',
        'title' => 'Бэтмен',
        'duration' => 7200,
        'country' => 'China',
        'creation_year' => 2022
    ],
    [
        'slug' => 'titanik',
        'title' => 'Титаник',
        'duration' => 7200,
        'country' => 'USA',
        'creation_year' => 2023
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

foreach (GENRES as $genre) {
    insertGenre($dbh, $genre);
}

foreach (COUNTRIES as $country) {
    insertGenre($dbh, $country);
}

$countries = getCountriesData($dbh);
foreach (MOVIE_POOL as $movie) {
    $country = $countries[array_rand($countries)];
    insertMovie($dbh, $country['id'], $movie['title'], $movie['duration'], $movie['creation_year']);
}

randomiseGenresToFilms($dbh);

foreach (HALL_POOL as $hall) {
    insertHall($dbh, $hall['nick'], $hall['number_of_rows'], $hall['number_of_seats_per_row']);
}

$movies = getMoviesData($dbh);
for ($i = 0; $i < 100; $i++) {
    $movie = $movies[array_rand($movies)];
    $hall = HALL_POOL[array_rand(HALL_POOL)];
    $session_ts = generateSessionTime();
    $id = insertRandomSession($dbh, $movie['id'], $hall['nick'], $session_ts, $session_ts = generateSessionTime(), rand(1, 40) * 50);
}

$sessions = getSessionsData($dbh);

for ($i = 0; $i < 200; $i++) {
    $session = $sessions[array_rand($sessions)];
    insertRandomTicket($dbh, $session['id'], rand(1, $session['number_of_rows']), rand(1, $session['number_of_seats_per_row']));
}
