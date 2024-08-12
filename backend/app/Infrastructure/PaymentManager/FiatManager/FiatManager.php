<?php
declare(strict_types=1);

namespace App\Infrastructure\PaymentManager\FiatManager;

use Illuminate\Support\Facades\Log;

class FiatManager
{
    private FiatApiInterface $fiatApi;
    public function __construct(
        FiatApiInterface $fiatApiInterface,
    ) {
           $this->fiatApi = $fiatApiInterface;
    }

    public function makePayment(string $toAddress, string $amount)
    {
        Log::debug("Попали в makePayment");
        return $this->fiatApi->sendMoney($toAddress,$amount);
    }

    public function test()
    {
        // Test the fiat API
        return $this->fiatApi->sendMoney('U431122090131', '1.00');
//        $a = '57.32';
//        return number_format((float)$a * 0.99, 2);
    }

}
