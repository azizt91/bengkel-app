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
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default vehicle types
        \DB::table('vehicle_types')->insert([
            [
                'name' => 'Motorcycle',
                'description' => 'Motorcycle vehicles',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Car',
                'description' => 'Car vehicles',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Truck',
                'description' => 'Truck vehicles',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_types');
    }
};
