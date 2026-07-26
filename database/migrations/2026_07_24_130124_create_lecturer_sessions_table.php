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
        Schema::create('lecturer_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('lecturer_id');
            $table->string('lecturer_name');
            $table->string('lecturer_email');
            $table->enum('session_status', ['on-progress', 'finished','ready']);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string("course_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturer_sessions');
    }
};
