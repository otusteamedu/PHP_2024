<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Infrastructure\OrderManager\OrderManager;
use App\Infrastructure\Repository\DbWorkflow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderManager $orderManager;
    public function __construct(
        public DbWorkflow $dbWorkflow
    )
    {
        $this->orderManager = new OrderManager($this->dbWorkflow);
    }

    public function createOrder(Request $request): JsonResponse
    {
        $orderManagerResponse = $this->orderManager->createOrder($request);
        return response()->json($orderManagerResponse);
    }

    public function getOrderStatus(int $orderId): JsonResponse
    {
        $order = $this->getOrderById($orderId);
        return response()->json($order->status);
    }

    public function getOrderForPay(int $orderId)
    {
        return $this->getOrderById($orderId);
    }

    private function getOrderById(int $id)
    {
        return $this->orderManager->getOrderById($id);
    }


    public function cancelOrderById(int $id): JsonResponse
    {
        $orderManagerResponse = $this->orderManager->cancelOrderById($id);
        return response()->json($orderManagerResponse);
    }

    public function testing()
    {
        // For testing purposes
        return $this->orderManager->test();
    }

}
