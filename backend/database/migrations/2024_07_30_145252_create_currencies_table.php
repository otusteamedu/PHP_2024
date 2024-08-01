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
        Schema::create('currencies', function (Blueprint $table) {
            $table->string("code")
                ->unique();
            $table->string("title");
            $table->string("type");
            $table->string("rate_to_usd");
            $table->string('inc_min_amount');
            $table->string('inc_max_amount');
            $table->string('outc_min_amount');
            $table->string('outc_max_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
