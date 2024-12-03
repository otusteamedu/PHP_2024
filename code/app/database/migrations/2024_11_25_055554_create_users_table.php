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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->nullable()->constrained();
            $table->string('name')->nullable()->constrained();
            $table->string('last_name')->nullable()->constrained();
            $table->string('second_name')->nullable()->constrained();
            $table->string('full_name')->nullable()->constrained();
            $table->string('email')->nullable()->constrained();
            $table->string('direction')->nullable()->constrained();
            $table->string('post')->nullable()->constrained();
            $table->date('birthday')->nullable()->constrained();
            $table->string("city")->nullable()->constrained();
            $table->string("phone")->nullable()->constrained();
            $table->string("work_phone")->nullable()->constrained();

            $table->string("personal_phone")->nullable()->constrained();
            $table->string("photo")->nullable()->constrained();

            //$table->foreignId('department_id')->constrained();
            //$table->integer('department_id')->unsigned();
            //$table->foreign("department_id")->references("id")->on('departments')->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
