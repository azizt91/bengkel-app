<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('service_bookings')->cascadeOnDelete();
            $table->foreignId('technician_id')->constrained('technicians')->cascadeOnDelete();
            $table->string('status');
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('progress_percentage')->default(0);
            $table->json('photos')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_progress');
    }
};
