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
        Schema::create('larajobs', function (Blueprint $table) {
            $table->id();
            $table->string('link');
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('salary')->nullable();
            $table->string('company')->nullable();
            $table->string('location')->nullable();
            $table->string('job_type')->nullable();
            $table->string('tags')->nullable();
            $table->boolean('seen')->default(false);
            $table->timestamp('pub_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('larajobs');
    }
};
