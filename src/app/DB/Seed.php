<?php

declare(strict_types=1);

namespace App\DB;

use Carbon\Carbon;
use Exception;
use Faker\Factory;
use PDO;
use PDOException;

class Seed
{
    protected ?PDO $dbConnection;

    protected bool $clearDb;

    public function __construct($clearDb = true)
    {
        $this->dbConnection = DbConnection::getInstance();
        $this->clearDb = $clearDb;
    }

    /**
     * @throws Exception
     */
    public function DbSeed(int $ticketsCount = 10_000): void
    {
        $faker = Factory::create('ru_RU');

        $now = Carbon::now('Europe/Moscow');

        if ($this->clearDb) {
            $this->clearDb();
        }

        // `title`, `genre`, `duration`, `release_date`, `description`
        $movies = [
            ['Фантастический фильм', 'Фантастика', 120, '2021-01-01', 'Описание фантастического фильма'],
            ['Приключенческий фильм', 'Приключения', 120, '2022-02-02', 'Описание приключенческого фильма'],
            ['Исторический фильм', 'История', 120, '2023-03-03', 'Описание исторического фильма'],
            ['Романтический фильм', 'Мелодрама', 120, '2024-04-04', 'Описание романтического фильма'],
        ];

        // `title`, `location`, `contacts`
        $movieTheatres = [
            ['Movie Theater 1', 'Location 1', $faker->address()],
            ['Movie Theater 2', 'Location 2', $faker->address()],
        ];

        // `cinema_id`, `title`, `capacity`, `type`
        $movieTheatreHalls = [
            [1, 'Movie Theater 1 Hall 1', 100, 1],
            [2, 'Movie Theater 2 Hall 1', 100, 1],
        ];

        $movieShows = $ticketsPerShow = $customers = $purchases = [];

        foreach (range(1, 50) as $i) {
            // `name`
            $customers[] = $faker->name;

            // `purchase_date`, `customer_id`
            $purchases[] = [$now->toDateTimeString(), $i];
            $purchases[] = [$now->toDateTimeString(), $i];
            $purchases[] = [$now->toDateTimeString(), $i];
        }


        $row = 0;
        $cinemaHallId = $showId = $movieId = 1;
        $showDate = $now->subDays(20)->midDay();
        $showCount = 0;
        $showDays = $ticketsCount > 10_000 ? 250 : 25;
        $showPerDay = 2;
        $totalShows = $showDays * $showPerDay;
        $seatsPerShow = range(1, 10);
        $ticketsPerCustomer = 5;

        foreach ($movieTheatreHalls as $movieTheatreHall) {
            while ($row < $totalShows) {
                $row++;
                $showCount++;

                // `cinema_hall_id`, `movie_id`, `start`, `end`
                $movieShows[] = [$cinemaHallId, $movieId, $showDate->toDateTimeString(), $showDate->addHours(2)->toDateTimeString()];
                $showDate = $now->midDay()->addHours((2 * $showCount));

                foreach ($seatsPerShow as $seatRowNum) {
                    foreach ($seatsPerShow as $seatNum) {
                        // `show_id`, `row`, `seat`, `price`
                        $ticketsPerShow[] = [$showId, $seatRowNum, $seatNum, $faker->randomElement([400, 600, 800, 1000, 1200, 1400])];
                    }
                }

                if ($row % $showPerDay == 0) {
                    $movieId = 0;
                    $showCount = 0;
                    $showDate = $showDate->addDays(1)->midDay();
                }

                $showId++;
                $movieId++;
            }

            $cinemaHallId++;
            $row = 0;
        }

        // public.movies
        $sql = 'INSERT INTO public.movies (title, genre, duration, release_date, description) VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->dbConnection->prepare($sql);

        foreach ($movies as $movie) {
            $rowsNumber = $stmt->execute($movie);
        }

        // public.cinemas
        $sql = 'INSERT INTO public.cinemas (title, location, contacts) VALUES (?, ?, ?)';
        $stmt = $this->dbConnection->prepare($sql);

        foreach ($movieTheatres as $movieTheatre) {
            $rowsNumber = $stmt->execute($movieTheatre);
        }

        // public.cinema_halls
        $sql = 'INSERT INTO public.cinema_halls (cinema_id, title, capacity, type) VALUES (?, ?, ?, ?)';
        $stmt = $this->dbConnection->prepare($sql);

        foreach ($movieTheatreHalls as $movieTheatreHall) {
            $rowsNumber = $stmt->execute($movieTheatreHall);
        }

        // public.customers
        $sql = 'INSERT INTO public.customers (name) VALUES (?)';
        $stmt = $this->dbConnection->prepare($sql);

        foreach ($customers as $customer) {
            $rowsNumber = $stmt->execute([$customer]);
        }

        // public.shows
        $sql = 'INSERT INTO public.shows (cinema_hall_id, movie_id, start, "end") VALUES (?, ?, ?, ?)';
        $stmt = $this->dbConnection->prepare($sql);

        foreach ($movieShows as $movieShow) {
            $rowsNumber = $stmt->execute($movieShow);
        }

        // public.tickets
        $ticketsPerShowChunks = array_chunk($ticketsPerShow, 10000);
        foreach ($ticketsPerShowChunks as $ticketsPerShowChunk) {
            $values = str_repeat('?,', count($ticketsPerShowChunk[array_key_first($ticketsPerShowChunk)]) - 1) . '?';
            // construct the entire query
            $sql = "INSERT INTO public.tickets (show_id, row, seat, price) VALUES " .
                // repeat the (?,?) sequence for each row
                str_repeat("($values),", count($ticketsPerShowChunk) - 1) . "($values)";

            $stmt = $this->dbConnection->prepare($sql);
            // execute with all values from $data
            $stmt->execute(array_merge(...$ticketsPerShowChunk));
        }

        // public.purchases
        $sql = 'INSERT INTO public.purchases (purchase_date, customer_id) VALUES (?, ?)';
        $stmt = $this->dbConnection->prepare($sql);

        foreach ($purchases as $purchase) {
            $rowsNumber = $stmt->execute($purchase);
        }

        //
        $selectedTickets = [];
        foreach ($purchases as $i => $purchase) {
            $purchaseId = $i + 1;

            foreach (range(1, $ticketsPerCustomer) as $i) {
                if (empty($selectedTickets)) {
                    $query = "SELECT public.tickets.id FROM public.tickets ORDER BY RANDOM() LIMIT 1";
                } else {
                    $selectedTicketIds = implode(',', $selectedTickets);
                    $query = "SELECT public.tickets.id FROM public.tickets WHERE public.tickets.id NOT IN ($selectedTicketIds) ORDER BY RANDOM() LIMIT 1";
                }
                $stmt = $this->dbConnection->prepare($query);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $selectedTickets[] = $result['id'];

                // public.purchase_tickets
                $sql = 'INSERT INTO public.purchase_tickets (purchase_id, ticket_id) VALUES (?, ?)';
                $stmt = $this->dbConnection->prepare($sql);
                $stmt->execute([$purchaseId, $result['id']]);

                // public.tickets
                $sql = 'UPDATE public.tickets SET available = false WHERE public.tickets.id = ?';
                $stmt = $this->dbConnection->prepare($sql);
                $stmt->execute([$result['id']]);
            }
        }

        echo 'Database successfully seeded' . PHP_EOL;
    }

    /**
     * @throws Exception
     */
    public function clearDb($filename = 'sql_db.sql'): void
    {
        $file = __DIR__ . '/' . $filename;

        if (!file_exists($file)) {
            throw new Exception('File not found: ' . $file);
        }

        $sql = file_get_contents($file);

        $this->dbConnection->exec($sql);

        echo 'Database successfully cleared' . PHP_EOL;
    }
}