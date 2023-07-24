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
        // Values can be HTML encoded


        Schema::create('job_posts', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->integer('job_creator_id');
            $table->string('title');
            $table->string('url');
            $table->string('category')->default('Job');
            $table->string('type')->nullable();
            $table->string('salary')->nullable();
            $table->string('location')->nullable();
            $table->string('company')->nullable();
            $table->string('logo_url')->nullable();
            $table->timestamps();
            $table->datetime('published_at');
            $table->datetime('notified_at');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
