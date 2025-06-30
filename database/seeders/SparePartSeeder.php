<?php

namespace Database\Seeders;

use App\Models\SparePart;
use Illuminate\Database\Seeder;

class SparePartSeeder extends Seeder
{
    public function run(): void
    {
        $parts = [
            ['OIL-5W30', 'Oli Mesin 5W-30 Synthetic', 150000, 50],
            ['OIL-10W40', 'Oli Mesin 10W-40', 135000, 40],
            ['FLT-OLI', 'Filter Oli', 45000, 60],
            ['FLT-UDARA', 'Filter Udara', 55000, 30],
            ['SPARK-PLUG', 'Busi NGK Standard', 35000, 100],
            ['BAT-NS40', 'Aki Kering NS40 35Ah', 650000, 15],
            ['BRAKE-PAD-FR', 'Kampas Rem Depan', 220000, 25],
            ['BRAKE-PAD-RR', 'Kampas Rem Belakang', 210000, 20],
            ['BELT-FAN', 'Fan Belt', 90000, 18],
            ['V-BELT', 'V Belt', 120000, 22],
            ['COOLANT', 'Radiator Coolant 1L', 40000, 35],
            ['WIPER-20', 'Karet Wiper 20 inch', 55000, 40],
            ['WIPER-18', 'Karet Wiper 18 inch', 52000, 35],
            ['LAMPU-H4', 'Lampu Headlamp H4 60/55W', 80000, 30],
            ['LAMPU-STOP', 'Bohlam Lampu Rem 21/5W', 15000, 50],
            ['FUEL-FLTR', 'Filter Bensin', 65000, 25],
            ['AIRCON-FLTR', 'Filter Kabin AC', 75000, 30],
            ['POWER-STEER', 'Fluid Power Steering 1L', 48000, 20],
            ['BRAKE-FLUID', 'Minyak Rem DOT3 300ml', 45000, 30],
            ['GEAR-OIL', 'Oli Gardan 80W-90 1L', 60000, 25],
        ];

        foreach ($parts as [$code, $name, $price, $stock]) {
            SparePart::updateOrCreate(
                ['part_code' => $code],
                [
                    'name' => $name,
                    'price' => $price,
                    'stock_quantity' => $stock,
                    'brand' => null,
                    'category' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}
