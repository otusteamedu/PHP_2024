<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('cur_from_code')->unsigned();
            $table->foreign('cur_from_code')->references('code')->on('currencies');
            $table->string('cur_to_code')->unsigned();
            $table->foreign('cur_to_code')->references('code')->on('currencies');
            $table->string('profit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
