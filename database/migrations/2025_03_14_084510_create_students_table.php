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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('account_type');
            $table->string('dp')->nullable();
            $table->string('init_name');
            $table->string('email');
            $table->string('password');
            $table->string('registration_no');
            $table->string('department');
            $table->string('batch');
            $table->string('year');
            $table->string('specialization');
            $table->string('destrict')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
