<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->text('status')->default('new');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
