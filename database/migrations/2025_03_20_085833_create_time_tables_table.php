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
        Schema::create('time_tables', function (Blueprint $table) {
            $table->id();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            // first year
            $table->string('year_1_lecturer')->nullable();
            $table->string('year_1_lecture')->nullable();
            $table->string('year_1_lecture_hall')->nullable();

            // second year
            $table->string('year_2_lecturer')->nullable();
            $table->string('year_2_lecture')->nullable();
            $table->string('year_2_lecture_hall')->nullable();

            // third year
            $table->string('year_3_lecturer')->nullable();
            $table->string('year_3_lecture')->nullable();
            $table->string('year_3_lecture_hall')->nullable();

            // fourth year
            $table->string('year_4_lecturer')->nullable();
            $table->string('year_4_lecture')->nullable();
            $table->string('year_4_lecture_hall')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('time_tables');
    }
};
