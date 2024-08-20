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
        Schema::create('exchanges', function (Blueprint $table) {
            $table->string('cur_from_code')->unsigned();
            $table->string('cur_to_code')->unsigned();
            $table->string('profit');
            $table->integer('status')->default(1);

            $table->foreign('cur_from_code')
                ->references('code')
                ->on('currencies')
                ->onDelete('cascade');

            $table->foreign('cur_to_code')
                ->references('code')
                ->on('currencies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchanges');
    }
};
