<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brands;
use App\Models\DeviceType;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir las marcas y sus tipos de dispositivos
        $brands = [
            'PC' => ['HP', 'Dell', 'Lenovo'],
            'LAPTOP' => ['Asus', 'Acer', 'Apple'],
            'MONITOR' => ['Samsung', 'LG', 'BenQ'],
            'PC ALL IN ONE' => ['HP', 'Dell', 'Lenovo'],
            'IMPRESORA' => ['Canon', 'Epson', 'Brother'],
            'CONSOLA DE JUEGOS' => ['PlayStation', 'Xbox', 'Nintendo'],
        ];

        foreach ($brands as $deviceType => $brandNames) {
            $deviceTypeId = DeviceType::where('tipo_dispositivo', $deviceType)->value('id');

            foreach ($brandNames as $brandName) {
                Brands::create([
                    'nombre_marca' => $brandName,
                    'id_tipo_dispositivo' => $deviceTypeId,
                ]);
            }
        }
    }
}
