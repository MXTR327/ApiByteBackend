<?php

namespace App\Http\Controllers\Transactions;

use App\Models\Maintenance;
use App\Models\DeviceMaintenance;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaintenanceTransactionRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class CrearMantenimientoController extends Controller
{
    public function crearMantenimiento(Request $request)
    {
        DB::beginTransaction();
        try {

            $id_cliente = $request->id_cliente;
            $id_recoge = $request->id_encargadoEntrega;
            $equipos = $request->equipos;
            $adelanto = $request->adelanto;

            // Validar los datos de entrada
            $request->validate([
                'id_cliente' => 'required|integer',
                'id_encargadoEntrega' => 'required|integer',
                'equipos' => 'required|array',
                'adelanto' => 'required|numeric',
            ]);

            $mantenimiento = Maintenance::create([
                'adelanto_mantenimiento' => $adelanto,
                'total_mantenimiento' => null,
                'saldo_re   stante' => null,
                'id_entidad' => $id_cliente,
                'id_recoge' => $id_recoge,
                'estado_mantenimiento' => 'Pendiente',
            ]);

            // Paso 2: Asociar los equipos al mantenimiento
            $totalMantenimiento = 0;
            foreach ($equipos as $equipoData) {
                $deviceMaintenance = DeviceMaintenance::create([
                    'id_equipo' => $equipoData['id_equipo'],
                    'id_mantenimiento' => $mantenimiento->id,
                    'serie' => $equipoData['numero_serie'] ?? null,
                    'precio_mantenimiento_equipo' => $equipoData['precio_mantenimiento_equipo'] ?? null,
                    'motivo_mantenimiento' => $equipoData['motivo_mantenimiento'] ?? null,
                    'condiciones_fisicas' => $equipoData['condiciones_fisicas'] ?? null,
                    'detalles_equipo_extra' => $equipoData['detalles_equipo_extra'] ?? null,
                    'diagnostico_equipo' => $equipoData['diagnostico_equipo'] ?? null,
                    'estado_actual' => 'creando',
                ]);
                $totalMantenimiento += $deviceMaintenance->precio_mantenimiento_equipo;
            }

            $mantenimiento->total_mantenimiento = $totalMantenimiento;
            $mantenimiento->save();

            DB::commit();
            return response()->json(['message' => 'Mantenimiento creado exitosamente', 'mantenimiento' => $mantenimiento], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(
                [
                    'error' => 'Error al crear el mantenimiento',
                    'details' => $e->getMessage(),
                    'validation_errors' => $e instanceof ValidationException ? $e->validator->errors() : []
                ],
                500
            );
        }
    }
}
