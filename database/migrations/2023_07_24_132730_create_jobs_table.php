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
        Schema::create('jobs', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('title');
            $table->string('link');
            $table->string('creator');
            $table->string('category');
            $table->string('location');
            $table->string('job_type');
            $table->string('salary')->nullable();
            $table->string('company');
            $table->string('company_logo');
            $table->dateTime('published_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
