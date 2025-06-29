<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Brands;
use App\Models\Models;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir los dispositivos a crear
        $devices = [
            ['tipo_dispositivo' => 'PC', 'marca' => 'HP', 'modelo' => 'Pavilion'],
            ['tipo_dispositivo' => 'LAPTOP', 'marca' => 'Asus', 'modelo' => 'ZenBook'],
            ['tipo_dispositivo' => 'MONITOR', 'marca' => 'Samsung', 'modelo' => 'Odyssey'],
            // Agrega más dispositivos según sea necesario
        ];

        foreach ($devices as $device) {
            $deviceTypeId = DeviceType::where('tipo_dispositivo', $device['tipo_dispositivo'])->value('id');
            $brandId = Brands::where('nombre_marca', $device['marca'])->where('id_tipo_dispositivo', $deviceTypeId)->value('id');
            $modelId = Models::where('nombre_modelo', $device['modelo'])->where('id_marca', $brandId)->value('id');

            Device::create([
                'id_tipo_dispositivo' => $deviceTypeId,
                'id_marca' => $brandId,
                'id_modelo' => $modelId,
            ]);
        }
    }
}
