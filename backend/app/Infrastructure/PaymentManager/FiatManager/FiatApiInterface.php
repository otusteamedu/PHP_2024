<?php
declare(strict_types=1);

namespace App\Infrastructure\PaymentManager\FiatManager;

interface FiatApiInterface
{
    public function validateAccount($account);

    public function request(string $method, array $params = []);


    public function sendMoney(string $account, string $amount);

}
