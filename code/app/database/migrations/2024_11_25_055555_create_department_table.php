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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer("sort");
            //$table->foreignId("parent_department_id")->references("id")->on('departments')->onDelete("cascade")->onUpdate("cascade");
            //$table->foreignId("head_user_id")->references("id")->on('users')->onDelete("cascade")->onUpdate("cascade");
            $table->integer("parent_department_id")->nullable()->constrained();
            $table->integer("head_user_id")->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department');
    }
};
