<?php

namespace App\Http\Controllers\Court;

use App\Models\Court;
use App\Models\GeneralType;
use App\Models\Region;

class EditController extends BaseController
{
    public function __invoke(Court $court)
    {
        $regions = Region::all();
        $general_types = GeneralType::all();
        return view("court.edit", compact(["court", "regions", "general_types"]));
    }
}
