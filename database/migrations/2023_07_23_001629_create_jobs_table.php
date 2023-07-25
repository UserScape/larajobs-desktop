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
            $table->ulid('id')->unique();
            $table->string('guid')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->string('title');
            $table->string('url');
            $table->datetime('published_at');
            $table->string('company');
            $table->string('logo')->nullable();
            $table->string('location');
            $table->boolean('remote');
            $table->boolean('fulltime');
            $table->string('salary')->nullable();
            $table->json('tags');
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
