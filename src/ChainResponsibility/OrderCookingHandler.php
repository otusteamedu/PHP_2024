<?php

declare(strict_types=1);

namespace App\ChainResponsibility;

use App\Dto\Order;
use App\Service\CookingService;
use App\Service\PaymentService;

class OrderCookingHandler extends OrderHandler
{
    public function __construct(private CookingService $cookingService)
    {
    }

    public function handle(Order $order): void
    {
        $this->cookingService->cook($order);
        parent::handle($order);
    }
}
