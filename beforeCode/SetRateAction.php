<?php

declare(strict_types=1);

namespace beforeCode;

use App\Helpers\TypeCaster;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\SetRateRequest;
use App\Models\Order\Order;
use App\Services\Order\OrderMetricService;

class SetRateAction extends Controller
{
    public function __invoke(Order $order, OrderMetricService $orderMetricService, SetRateRequest $request): void
    {
        $orderMetricService->setRate(
            $order->id,
            TypeCaster::int($request->input('rate'))
        );
    }
}
