<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Включаем расширение uuid-ossp (один раз в базе)
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        Schema::create('courts', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid_generate_v4()'));
            $table->text("name");

            $table->uuid('region_id')->nullable();
            $table->index('region_id', 'court_region_idx');
            $table->foreign('region_id', 'court_region_fk')->on('regions')->references('id');

            $table->string("cass_region");

            $table->uuid('general_type_id')->nullable();
            $table->index('general_type_id', 'court_general_type_idx');
            $table->foreign('general_type_id', 'court_general_type_fk')->on('general_types')->references('id');

            $table->text("address")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("site")->nullable();
            $table->smallInteger("site_type")->nullable();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};
