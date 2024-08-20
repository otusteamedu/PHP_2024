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
        Schema::create('fiat_withdraws', function (Blueprint $table) {
            $table->id();
            $table->integer('orderId')->unsigned();
            $table->string('coin')->unsigned();
            $table->string('amount');
            $table->string('txid');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('orderId')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            $table->foreign('coin')
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
        Schema::dropIfExists('fiat_withdraws');
    }
};
