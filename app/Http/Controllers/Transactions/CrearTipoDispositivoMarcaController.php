<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Brands;
use App\Models\DeviceType;
use App\Models\DeviceTypeBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrearTipoDispositivoMarcaController extends Controller
{
    public function crearTipoDispositivoMarca(Request $request)
    {
        DB::beginTransaction();
        try {
            // Paso 1: Crear el tipo de dispositivo
            $datosTipoDispositivo = $request->datos_tipoDispositivo;
            $marcas = $request->datos_marca;

            $tipoDispositivo = DeviceType::create([
                'tipo_dispositivo' => $datosTipoDispositivo
            ]);

            // Paso 2: Crear las marcas
            $marcasCreadas = [];
            foreach ($marcas as $marca) {
                $marcaCreada = Brands::create([
                    'nombre_marca' => $marca['nombre_marca']
                ]);
                $marcasCreadas[] = $marcaCreada;
            }

            // Paso 3: Asociar las marcas al tipo de dispositivo
            foreach ($marcasCreadas as $marca) {
                DeviceTypeBrand::create([
                    'id_tipo_dispositivo' => $tipoDispositivo->id,
                    'id_marca' => $marca->id
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Tipo de dispositivo y marcas creados exitosamente'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(
                [
                    'error' => 'Error al crear el tipo de dispositivo y marcas',
                    'details' => $e->getMessage()
                ],
                500
            );
        }
    }
}
