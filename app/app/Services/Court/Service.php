<?php

namespace App\Services\Court;

use App\Models\Court;

class Service
{
    public function store($data)
    {
        Court::create($data);
    }

    public function update($court, $data)
    {
        $court->update($data);
    }
}
