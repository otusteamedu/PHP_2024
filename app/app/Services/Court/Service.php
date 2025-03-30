<?php

namespace App\Services\Court;

use App\Models\Court;

class Service
{
    function store($data)
    {
        Court::create($data);
    }

    function update($court, $data)
    {
        $court->update($data);
    }
}
