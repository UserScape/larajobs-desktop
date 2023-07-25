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
        Schema::create('job_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('link');
            $table->string('location')->nullable();
            $table->string('salary')->nullable();
            $table->dateTime('published_at');
            $table->dateTime('applied_at')->nullable();
            $table->dateTime('read_at')->nullable();
            $table->foreignIdFor(\App\Models\Company::class)->nullable()->constrained()->nullOnDelete();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_items');
    }
};
