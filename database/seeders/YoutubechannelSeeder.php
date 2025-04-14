<?php

namespace Database\Seeders;

use App\Models\Youtubechannel;
use Illuminate\Database\Seeder;

class YoutubechannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Youtubechannel::factory()->count(50)->create();
    }
}
