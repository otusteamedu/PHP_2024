<?php

namespace App\Http\Controllers\Court;

use App\Models\Court;

class ShowController extends BaseController
{
    public function __invoke(Court $court)
    {
        return view("court.show", compact("court"));
    }
}
