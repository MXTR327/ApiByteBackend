<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeviceType;

class DeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Step 1: Seed Device Types
        $deviceTypes = [
            'PC',
            'LAPTOP',
            'MONITOR',
            'PC ALL IN ONE',
            'IMPRESORA',
            'CONSOLA DE JUEGOS',
        ];


        foreach ($deviceTypes as $type) {
            DeviceType::create(['tipo_dispositivo' => $type]);
        }
    }
}
