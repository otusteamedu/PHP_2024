<?php

namespace App;

use App\DataMapper\FilmMapper;

class App
{
    public function run()
    {
        $db = DB::getInstance();
        $mapper = new FilmMapper($db);

//        $result = $mapper->delete(2);

//        $films = $mapper->all(); // Film[]
//        $films[1]->getCountries();

        $film = $mapper->find(1); //Film
        $countries = $film->getCountries();
    }

    public static function env(): array
    {
        return parse_ini_file('.env');
    }
}