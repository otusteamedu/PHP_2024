<?php

namespace App\Infrastructure\RateManager;

use App\Models\Balance;
use App\Models\Currency;
use App\Models\Exchange;

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
            $rates['currencies'][$code] = [
                'title' => $value['title'],
                'type' => $value['type'],
                'rate_to_usd' => $value['rate_to_usd'],
                'balance' => $balances[$code],
                'inc_min_amount' => $value['inc_min_amount'],
                'inc_max_amount' => $value['inc_max_amount'],
                'outc_min_amount' => $value['outc_min_amount'],
                'outc_max_amount' => $value['outc_max_amount'],
            ];
        }

        $profitPairs = $this->getRatesProfitPair();

        foreach ($profitPairs as $key => $value) {
            $rates['exchange_pairs'][$key] = $value;
        }

        return $rates;
    }

    private function getRatesProfitPair(): array
    {
        $profitPairs = [];
        foreach (Exchange::where('status',1)->get() as $record) {
            $profitPairs[$record->cur_from_code][] = [
                'cur_to' => $record->cur_to_code,
                'profit' => $record->profit,
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
                'inc_min_amount' => $currency->inc_min_amount,
                'inc_max_amount' => $currency->inc_max_amount,
                'outc_min_amount' => $currency->outc_min_amount,
                'outc_max_amount' => $currency->outc_max_amount,
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
