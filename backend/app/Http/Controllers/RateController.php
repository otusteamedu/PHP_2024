<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Infrastructure\RateManager\RateManager;
use Illuminate\Http\JsonResponse;

class RateController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $rateManagerResponse = new RateManager();
        return response()->json($rateManagerResponse());
    }

}