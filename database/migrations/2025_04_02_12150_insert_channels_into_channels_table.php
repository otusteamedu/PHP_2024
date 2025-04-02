<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class InsertChannelsIntoChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('channels')->insert([
            [
                'id' => 1,
                'name' => 'ТНТ',
                'created_at' => '2025-01-02 15:35:43',
                'updated_at' => '2025-01-02 15:35:45',
            ],
            [
                'id' => 2,
                'name' => 'Россия',
                'created_at' => '2025-01-02 15:36:00',
                'updated_at' => '2025-01-02 15:36:01',
            ],
            [
                'id' => 3,
                'name' => 'СТС',
                'created_at' => '2025-01-02 15:35:59',
                'updated_at' => '2025-01-02 15:36:00',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
