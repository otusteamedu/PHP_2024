<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Infrastructure\OrderManager\OrderManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function createOrder(Request $request): JsonResponse
    {
        $orderManagerResponse = (new OrderManager)->createOrder($request);
        return response()->json($orderManagerResponse);
    }

    public function getOrderForPay(int $orderId): JsonResponse
    {
        return $this->getOrderById($orderId);
    }

    private function getOrderById(int $id)
    {
        return (new OrderManager)->getOrderById($id);
    }


    public function cancelOrderById(int $id): JsonResponse
    {
        $orderManagerResponse = (new OrderManager)->cancelOrderById($id);
        return response()->json($orderManagerResponse);
    }

    public function testing()
    {
        // For testing purposes
        return (new OrderManager)->getIncomingAsset('usdt_trc20');
    }

}
