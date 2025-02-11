<?php

namespace App;

class App
{
    public function run()
    {
        Router::route();
    }

    public static function env(): array
    {
        return parse_ini_file('.env');
    }

    public static function seedData(): array
    {
        return include 'seed.php';
    }
}