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
        Schema::create('howyouse', function (Blueprint $table) {
            $table->id();
            $table->text('dosage_instructions');
            $table->text('side_effects');
            $table->text('precaution');
            $table->text('interaction');
            $table->text('storage');
            $table->text('brand_names');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('howyouse');
    }
};
