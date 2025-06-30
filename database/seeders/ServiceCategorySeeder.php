<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Ganti Oli & Filter', 'description' => 'Penggantian oli mesin dan filter oli', 'estimated_duration' => 45, 'base_price' => 200000, 'is_active' => true],
            ['name' => 'Service Berkala 10.000 km', 'description' => 'Pemeriksaan dan penggantian komponen sesuai jadwal', 'estimated_duration' => 180, 'base_price' => 500000, 'is_active' => true],
            ['name' => 'Tune Up', 'description' => 'Penyetelan performa mesin untuk efisiensi optimal', 'estimated_duration' => 240, 'base_price' => 600000, 'is_active' => true],
            ['name' => 'Ganti Kampas Rem', 'description' => 'Penggantian brake pad depan atau belakang', 'estimated_duration' => 120, 'base_price' => 400000, 'is_active' => true],
            ['name' => 'Spooring & Balancing', 'description' => 'Penyetelan geometri roda dan balancing ban', 'estimated_duration' => 90, 'base_price' => 150000, 'is_active' => true],
            ['name' => 'Servis AC Mobil', 'description' => 'Pemeriksaan dan perbaikan sistem AC', 'estimated_duration' => 180, 'base_price' => 800000, 'is_active' => true],
            ['name' => 'Overhaul Mesin', 'description' => 'Bongkar total dan rebuild mesin', 'estimated_duration' => 5760, 'base_price' => 8000000, 'is_active' => true],
            ['name' => 'Lain-lain (Custom)', 'description' => 'Permintaan servis di luar daftar', 'estimated_duration' => 60, 'base_price' => 0, 'is_active' => true],
        ];

        foreach ($data as $item) {
            ServiceCategory::updateOrCreate(['name' => $item['name']], $item);
        }
    }
}
