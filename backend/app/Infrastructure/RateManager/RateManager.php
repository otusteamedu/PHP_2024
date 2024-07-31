<?php

namespace App\Infrastructure\RateManager;

use App\Models\Balance;
use App\Models\Currency;
use App\Models\Setting;

class RateManager
{
    public function __invoke(): array
    {
        $rates = $this->getRates();

        return $rates;
    }

    private function getRates(): array
    {
        $rates = [
            'currencies' => [],
            'exchange_pairs' => [],
        ];
        $currencies = $this->getAllCurrencies();
        $balances = $this->getBalances();

        foreach ($currencies as $code => $value) {
            $rates['currencies'][] = [
                'code' => $code,
                'title' => $value['title'],
                'type' => $value['type'],
                'rate_to_usd' => $value['rate_to_usd'],
                'balance' => $balances[$code],
            ];
        }

        $profitPairs = $this->getRatesProfitPair();
        foreach ($profitPairs as $pair) {
            $rates['exchange_pairs'][][$pair['cur_from']][] = [
                'cur_to' => $pair['cur_to'],
                'profit' => $pair['profit']
            ];

//            [$pair['cur_from']][] = [
//                'cur_to' => $pair['cur_to'],
//                'profit' => $pair['profit'],
//            ]];
        }

        return $rates;
    }

    private function getRatesProfitPair(): array
    {
        $profitPairs = [];
        foreach (Setting::where('status',1)->get() as $setting) {
            $profitPairs[] = [
                'cur_from' => $setting->cur_from_code,
                'cur_to' => $setting->cur_to_code,
                'profit' => $setting->profit,
            ];
        }
        return $profitPairs;
    }

    private function getAllCurrencies(): array
    {
        $currencies = [];
        foreach (Currency::all() as $currency) {
            $currencies[$currency->code] = [
                'title' => $currency->title,
                'type' => $currency->type,
                'rate_to_usd' => $currency->rate_to_usd,
            ];
        }
        return $currencies;
    }

    private function getBalances(): array
    {
        $balances = [];
        foreach (Balance::all() as $balance) {
            $balances[$balance->cur_code] = $balance->balance;
        }
        return $balances;
    }
}
