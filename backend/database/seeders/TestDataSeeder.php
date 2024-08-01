<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('currencies')->insert([
            [
                'code' => 'volet_usd',
                'title' => 'Volet USD',
                'type' => 'fiat',
                'rate_to_usd' => '1.00',
                'inc_min_amount' => '10.00',
                'inc_max_amount' => '100.00',
                'outc_min_amount' => '10.00',
                'outc_max_amount' => '100.00',
            ],
            [
                'code' => 'usdt_trc20',
                'title' => 'USDT TRC20',
                'type' => 'crypto',
                'rate_to_usd' => '1.00',
                'inc_min_amount' => '10.00',
                'inc_max_amount' => '100.00',
                'outc_min_amount' => '10.00',
                'outc_max_amount' => '100.00',
            ],
            [
                'code' => 'usdt_erc20',
                'title' => 'USDT ERC20',
                'type' => 'crypto',
                'rate_to_usd' => '1.00',
                'inc_min_amount' => '10.00',
                'inc_max_amount' => '100.00',
                'outc_min_amount' => '10.00',
                'outc_max_amount' => '100.00',
            ],
        ]);

        DB::table('balances')->insert([
            [
                'cur_code' => 'volet_usd',
                'balance' => '100.00',
            ],
            [
                'cur_code' => 'usdt_trc20',
                'balance' => '110.00',
            ],
            [
                'cur_code' => 'usdt_erc20',
                'balance' => '105.00',
            ],
        ]);

        DB::table('exchanges')->insert([
            [
                'cur_from_code' => 'volet_usd',
                'cur_to_code' => 'usdt_trc20',
                'profit' => '1.03',
                'status' => 1
            ],
            [
                'cur_from_code' => 'volet_usd',
                'cur_to_code' => 'usdt_erc20',
                'profit' => '1.06',
                'status' => 1
            ],
            [
                'cur_from_code' => 'usdt_erc20',
                'cur_to_code' => 'volet_usd',
                'profit' => '1.01',
                'status' => 1
            ],
            [
                'cur_from_code' => 'usdt_trc20',
                'cur_to_code' => 'volet_usd',
                'profit' => '1.015',
                'status' => 1
            ],
        ]);
    }
}
