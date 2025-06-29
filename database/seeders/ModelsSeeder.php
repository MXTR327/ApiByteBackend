<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Models;
use App\Models\Brands;
use App\Models\DeviceType; // Agregado para obtener el tipo de dispositivo

class ModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir los modelos y sus marcas considerando el tipo de dispositivo
        $models = [
            'PC' => [
                'HP' => ['Pavilion', 'Omen', 'Spectre'],
                'Dell' => ['XPS', 'Inspiron', 'Alienware'],
                'Lenovo' => ['ThinkPad', 'IdeaPad'],
            ],
            'LAPTOP' => [
                'Asus' => ['ZenBook', 'VivoBook', 'ROG'],
                'Acer' => ['Aspire', 'Swift'],
                'Apple' => ['MacBook Air', 'MacBook Pro'],
            ],
            'MONITOR' => [
                'Samsung' => ['Odyssey', 'Curved', 'UltraWide'],
                'LG' => ['UltraGear', 'UltraFine', 'NanoCell'],
                'BenQ' => ['GW2480', 'PD3220U', 'SW321C'],
            ],
            'PC ALL IN ONE' => [
                'HP' => ['Pavilion All-in-One', 'Envy All-in-One'],
                'Dell' => ['Inspiron All-in-One', 'XPS All-in-One'],
                'Lenovo' => ['IdeaCentre AIO', 'Yoga AIO'],
            ],
            'IMPRESORA' => [
                'Canon' => ['PIXMA', 'imageCLASS'],
                'Epson' => ['EcoTank', 'WorkForce'],
                'Brother' => ['MFC', 'HL'],
            ],
            'CONSOLA DE JUEGOS' => [
                'PlayStation' => ['PS5', 'PS4'],
                'Xbox' => ['Xbox Series X', 'Xbox One'],
                'Nintendo' => ['Switch', 'Wii U'],
            ],
        ];

        foreach ($models as $deviceType => $brands) {
            $deviceTypeId = DeviceType::where('tipo_dispositivo', $deviceType)->value('id');

            foreach ($brands as $brand => $modelNames) {
                $brandId = Brands::where('nombre_marca', $brand)->where('id_tipo_dispositivo', $deviceTypeId)->value('id');

                foreach ($modelNames as $modelName) {
                    Models::create([
                        'nombre_modelo' => $modelName,
                        'id_marca' => $brandId,
                    ]);
                }
            }
        }
    }
}
