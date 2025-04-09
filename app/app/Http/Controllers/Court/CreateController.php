<?php

namespace App\Http\Controllers\Court;

use App\Models\GeneralType;
use App\Models\Region;

class CreateController extends BaseController
{
    public function __invoke()
    {
        $regions = Region::all();
        $general_types = GeneralType::all();
        return view("court.create", compact("regions", "general_types"));
    }
}
