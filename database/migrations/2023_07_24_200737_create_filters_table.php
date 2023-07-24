<?php

use App\Enums\FilterField;
use App\Enums\FilterOperation;
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
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->enum('field', array_map(fn ($case) => $case->value, FilterField::cases()));
            $table->enum('operation', array_map(fn ($case) => $case->value, FilterOperation::cases()));
            $table->string('query');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filters');
    }
};
