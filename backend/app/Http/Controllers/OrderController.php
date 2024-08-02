<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Infrastructure\OrderManager\OrderManager;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function createOrder(): JsonResponse
    {
        $orderManagerResponse = (new OrderManager)->CreateOrder();
        return response()->json($orderManagerResponse());
    }

}
