<?php

namespace App\Http\Controllers\Court;

use App\Http\Controllers\Controller;
use App\Services\Court\Service;

class BaseController extends Controller
{
    public function __construct(
        public Service $service
    ) {
        // Empty
    }
}
