<?php

namespace App;

class App
{
    public function run()
    {
        echo 11;
    }

    public static function env(): array
    {
        return parse_ini_file('.env');
    }
}