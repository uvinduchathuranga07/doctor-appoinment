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
    Schema::table('prescriptions', function (Blueprint $table) {
        // Drop doctor_schedule_id only if it exists
        if (Schema::hasColumn('prescriptions', 'doctor_schedule_id')) {
            $table->dropForeign(['doctor_schedule_id']);
            $table->dropColumn('doctor_schedule_id');
        }
    });

    Schema::table('prescriptions', function (Blueprint $table) {
        // Add appointment_id only if it doesn't exist
        if (!Schema::hasColumn('prescriptions', 'appointment_id')) {
            $table->foreignId('appointment_id')->after('id')->constrained()->onDelete('cascade');
        }

        // Change details to json only if it exists
        if (Schema::hasColumn('prescriptions', 'details')) {
            $table->json('details')->change();
        }

        // Add status if missing
        if (!Schema::hasColumn('prescriptions', 'status')) {
            $table->string('status')->default('pending')->after('details');
        }

        // Add pharmacy_name if missing
        if (!Schema::hasColumn('prescriptions', 'pharmacy_name')) {
            $table->string('pharmacy_name')->nullable()->after('status');
        }
    });
}

    public function down(): void
    {
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropForeign(['appointment_id']);
            $table->dropColumn(['appointment_id', 'status', 'pharmacy_name']);
        });

        Schema::table('prescriptions', function (Blueprint $table) {
            $table->foreignId('doctor_schedule_id')->constrained()->onDelete('cascade');
            $table->text('details')->change();
        });
    }
};
