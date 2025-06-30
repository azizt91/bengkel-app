<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->integer('estimated_duration')->nullable()->after('booking_date'); // in minutes or hours? assume minutes. we'll display hours
        });
    }

    public function down(): void
    {
        Schema::table('service_bookings', function (Blueprint $table) {
            $table->dropColumn('estimated_duration');
        });
    }
};
