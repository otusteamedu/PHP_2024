<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\Order;

class PaymentService
{
    public function pay(Order $order): void
    {
        echo "Оплата заказа\n";
        sleep(3);
        echo "Заказ оплачен\n";
    }
}
