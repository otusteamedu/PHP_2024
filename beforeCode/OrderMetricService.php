<?php

declare(strict_types=1);

namespace beforeCode;

use App\Events\OrderRateSet;
use App\Models\Order\OrderMetric;

class OrderMetricService
{
    private function getOrderMetricByOrderId(int $orderId): OrderMetric
    {
        return OrderMetric::firstOrCreate([
            'order_id' => $orderId
        ]);
    }

    public function viewMail(int $orderId): void
    {
        $metric = $this->getOrderMetricByOrderId($orderId);
        $metric->viewed_mail = true;
        $metric->save();
    }

    public function viewPage(int $orderId): void
    {
        $metric = $this->getOrderMetricByOrderId($orderId);
        $metric->viewed_page = true;
        $metric->save();
    }

    public function setRate(int $orderId, int $rate): void
    {
        $metric = $this->getOrderMetricByOrderId($orderId);
        $metric->rate = $rate;
        $metric->save();

        OrderRateSet::dispatch($metric->order);
    }
}
