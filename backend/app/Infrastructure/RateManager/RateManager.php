<?php

namespace App\Infrastructure\RateManager;

use App\Models\Rate;
use App\Models\Setting;

class RateManager
{
    public function __invoke(): array
    {
        $rates = $this->getRates();

        return [
            'rates' => $rates,
            'base_currency' => 'USD'
        ];
    }

    private function getRates(): array
    {
        $ratesToUsd = [];
        $profitPairs = [];
        foreach (Setting::all() as $setting) {
            $profitPairs[] = [
                'cur_from' => $setting->cur_from_code,
                'cur_to' => $setting->cur_to_code,
                'profit' => $setting->profit,
            ];
        }
        return $profitPairs;
    }

    private function getRatesProfitPair($cur_from, $cur_to): array
    {
        $profit = Setting::where('cur_from_code', '=', $cur_from)
            ->where('cur_to_code', '=', $cur_to)
            ->column('profit')
            ->get();
        return [
            'cur_from' => $cur_from,
            'cur_to' => $cur_to,
            'profit' => $profit[0]?? 0,
        ];
    }

}
