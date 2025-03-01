<?php

namespace App\Model;

class Country
{
    public ?int $id;
    public string $name;

    public static function create($name, $id = null): Country
    {
        $country = new Country();
        $country->name = $name;
        $country->id = $id;

        return $country;
    }
}