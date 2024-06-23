<?php

declare(strict_types=1);

namespace App\ChainResponsibility;

use App\Dto\Order;
use App\Service\PaymentService;
class OrderPaymentHandler extends OrderHandler
{
    public function __construct(private PaymentService $paymentService)
    {
    }

    public function handle(Order $order): void
    {
        $this->paymentService->pay($order);
        parent::handle($order);
    }
}
