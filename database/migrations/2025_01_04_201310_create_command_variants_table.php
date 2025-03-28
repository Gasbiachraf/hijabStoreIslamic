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
        Schema::create('command_variants', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->integer('salePrice');
            $table->string('size')->nullable();
            $table->foreignId('command_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('variant_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('command_variants');
    }
};
