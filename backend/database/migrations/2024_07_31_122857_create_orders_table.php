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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('status');
            $table->string("cur_from")->unsigned();
            $table->string("cur_to")->unsigned();
            $table->string("amount_from");
            $table->string("amount_to");
            $table->string("rateFrom");
            $table->string("rateTo");
            $table->string("email");
            $table->string("recipient_account");
            $table->string("incoming_asset");
            $table->timestamps();

            $table->foreign('cur_from')
                ->references('code')
                ->on('currencies')
                ->onDelete('cascade');

            $table->foreign('cur_to')
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
        Schema::dropIfExists('orders');
    }
};
