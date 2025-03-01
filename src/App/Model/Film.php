<?php

namespace App\Model;

use App\DataMapper\LazyLoader;

class Film
{
    public ?int $id;
    public string $name;
    public int $year;
    public string $start_date;
    private $lazyLoadedCountries;
    public array|null $countries = null;

    public static function create($name, $year, $id = null): Film
    {
        $film = new Film();
        $film->name = $name;
        $film->year = $year;
        $film->id = $id;

        return $film;
    }

    public function setCountries($callback)
    {
        $this->lazyLoadedCountries = new LazyLoader($callback);
    }

    public function getCountries()
    {
        if (is_null($this->countries)) {
            $this->countries = call_user_func($this->lazyLoadedCountries);
        }

        return $this->countries;
    }
}