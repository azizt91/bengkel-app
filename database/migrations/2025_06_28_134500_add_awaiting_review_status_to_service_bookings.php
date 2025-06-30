<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add new value to the status enum of service_bookings
        DB::statement("ALTER TABLE service_bookings MODIFY COLUMN status ENUM('pending','in_progress','awaiting_review','completed') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove awaiting_review value
        DB::statement("ALTER TABLE service_bookings MODIFY COLUMN status ENUM('pending','in_progress','completed') NOT NULL DEFAULT 'pending'");
    }
};
