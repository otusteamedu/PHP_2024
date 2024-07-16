<?php

namespace src\Base;

use Exception;

class Seed
{
    protected array $genres;
    protected array $titles;
    protected array $descriptions;
    protected array $years;
    protected array $countries;
    protected array $halls;
    protected array $movies;
    protected Operations $operations;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->operations = new Operations();

        $this->setParams();
        $this->seed();
    }

    protected function setParams(): void
    {
        $this->setTitles();
        $this->setGenres();
        $this->setDescriptions();
        $this->setCountries();
        $this->setYears();
        $this->setMovies();
        $this->setHalls();
    }

    protected function setTitles(): void
    {
        $this->titles = [
            '1+1',
            'Интерстеллар',
            'Зеленая миля',
            'Побег из Шоушенка',
            'Бойцовский клуб',
        ];
    }

    protected function setGenres(): void
    {
        $this->genres = [
            'comedy',
            'drama',
            'fantasy',
            'family',
            'horror',
        ];
    }

    protected function setDescriptions(): void
    {
        $this->descriptions = [
            'Молодая пара в компании других богатеев отправляется на эксклюзивный ужин в знаменитый ресторан, который находится на небольшом острове.',
            'Одно изысканное блюдо сменяет другое, когда выясняется, что шеф-повар и его команда неплохо изучили сегодняшних гостей и прекрасно осведомлены не только об их вкусовых предпочтениях.',
            'И кроме того, меню содержит неприятные сюрпризы.',
            '20-летняя Аой в поте лица трудится в семейной лапшичной на задворках Бангкока, чтобы обеспечивать пожилого отца и сестру-старшеклассницу.',
            'От матери ей достался талант управляться с воком, и девушка достигла в этом определённого мастерства.',
        ];
    }

    protected function setYears(): void
    {
        $this->years = [
            2000,
            2010,
            2015,
            2020,
            2024,
        ];
    }

    protected function setCountries(): void
    {
        $this->countries = [
            'USSR',
            'China',
            'USA',
            'Russia',
        ];
    }

    protected function setMovies(): void
    {
        $this->movies = [];
        foreach ($this->titles as $title) {
            $this->movies[] = [
                'title' => $title,
                'genre' => $this->genres[array_rand($this->genres)],
                'country' => $this->countries[array_rand($this->countries)],
                'year' => $this->years[array_rand($this->years)],
                'description' => $this->descriptions[array_rand($this->descriptions)],
                'duration' => rand(5000, 8000),
            ];
        }
    }

    protected function setHalls(): void
    {
        $this->halls = [
            [
                'name' => 'A',
                'rows' => 4,
                'columns' => 10,
            ],
            [
                'name' => 'B',
                'rows' => 5,
                'columns' => 12,
            ],
            [
                'name' => 'C',
                'rows' => 6,
                'columns' => 14,
            ],
        ];
    }

    protected function seed(): void
    {
        $this->seedGenres();
        $this->seedMovies();
        $this->seedHalls();
        $this->seedSessions();
        $this->seedTickets();
    }

    protected function seedGenres(): void
    {
        foreach ($this->genres as $genre) {
            $this->operations->insertGenre($genre);
        }
    }

    protected function seedMovies(): void
    {
        foreach ($this->movies as $movie) {
            $this->operations->insertMovie(
                $movie['title'],
                $movie['duration'],
                $movie['description'],
                $movie['country'],
                $movie['year'],
            );
        }
    }

    protected function seedHalls(): void
    {
        foreach ($this->halls as $hall) {
            $this->operations->insertHall($hall['name'], $hall['rows'], $hall['columns']);
        }
    }

    protected function seedSessions(): void
    {
        $movies = $this->operations->getMovies();
        $halls = $this->operations->getHalls();
        $sessionsCount = 30;

        for ($i = 1; $i < $sessionsCount; $i++) {
            $movie = $movies[array_rand($movies)];
            $hall = $halls[array_rand($halls)];

            $startHour = rand(8, 20);
            $startMinute = rand(0, 59);
            $startDate = new \DateTimeImmutable("2024-07-{$i} {$startHour}:{$startMinute}:00");
            $endDate = $startDate->add(new \DateInterval("PT{$movie['duration']}S"));

            $this->operations->createSession($movie['id'], $hall['name'], $startDate->format('Y-m-d H:i:s'), $endDate->format('Y-m-d H:i:s'), 500 + rand(0, 100));
        }
    }

    protected function seedTickets(): void
    {
        $sessions = $this->operations->getSessions();
        $ticketsCount = 10;

        for ($i = 0; $i < $ticketsCount; $i++) {
            $session = $sessions[array_rand($sessions)];
            $ticketRow = rand(1, $session['rows']);
            $ticketColumn = rand(1, $session['columns']);
            $price = $this->getTicketPrice($session, $ticketRow, $ticketColumn);

            $this->operations->createTicket($session['id'], $ticketRow, $ticketColumn, $price);
        }
    }

    protected function getTicketPrice($session, $row, $column): int
    {
        $price = $session['basePrice'];
        $priceMultiplier = 0;
        /* First rows are expensive, far rows are cheaper */
        $priceMultiplier += match (true) {
            $row <= 2 => 0.1,
            $row >= $session['rows'] - 1 => -0.1,
            default => 0,
        };

        /* Center columns are expensive, far columns are cheaper */
        $priceMultiplier += match (true) {
            $column <= 2 || $column >= $session['columns'] - 2 => -0.1,
            $column >= ($session['columns'] / 2) - 3 && $column <= ($session['columns'] / 2) + 3 => 0.1,
            default => 0,
        };


        if ($priceMultiplier !== 0) {
            $extraPrice = $priceMultiplier * $price;

            $price += $extraPrice;
        }

        return (int)$price;
    }
}
