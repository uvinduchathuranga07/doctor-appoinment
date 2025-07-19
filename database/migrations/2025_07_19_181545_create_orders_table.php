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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');
            $table->json('product_ids');
            $table->string('payment_status'); // e.g., 'pending', 'paid', 'failed'
            $table->unsignedBigInteger('prescription_id')->nullable();
            $table->string('pharmacy_name');

            $table->timestamps();

            // Foreign keys (optional)
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
