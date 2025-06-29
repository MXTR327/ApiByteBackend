<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaintenanceRequest;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('cliente', 'devicesMaintenance')->get();

        // Transformar los datos para devolver solo lo necesario
        $maintenances = $maintenances->map(function ($maintenance) {
            return [
                'id' => $maintenance->id,
                'adelanto_mantenimiento' => $maintenance->adelanto_mantenimiento,
                'total_mantenimiento' => $maintenance->total_mantenimiento,
                'saldo_restante' => $maintenance->saldo_restante,
                'cantidad_equipos' => $maintenance->devicesMaintenance->count(),
                'nombre_cliente' => $maintenance->cliente->nombre_entidad,
                'nombre_recoge' => $maintenance->cliente->nombre_entidad,
                'estado_mantenimiento' => $maintenance->estado_mantenimiento,
                'fecha_registro' => $maintenance->created_at,
            ];
        });

        return response()->json($maintenances);
    }

    public function store(StoreMaintenanceRequest $request)
    {
        $maintenance = Maintenance::create($request->validated());

        return response()->json([
            'maintenance' => $maintenance
        ], 201);
    }
    public function show($id)
    {
        $maintenance = Maintenance::with('cliente')->findOrFail($id);

        return response()->json([
            'id' => $maintenance->id,
            'adelanto_mantenimiento' => $maintenance->adelanto_mantenimiento,
            'total_mantenimiento' => $maintenance->total_mantenimiento,
            'saldo_restante' => $maintenance->saldo_restante,
            'cantidad_equipos' => $maintenance->devicesMaintenance->count(),
            'cliente' => [
                'id' => $maintenance->cliente->id,
                'nombre' => $maintenance->cliente->nombre_entidad,
            ],
            'cliente_recoge' => [
                'id' => $maintenance->cliente->id,
                'nombre' => $maintenance->cliente->nombre_entidad,
            ],
            'estado_mantenimiento' => $maintenance->estado_mantenimiento,
            'fecha_registro' => $maintenance->created_at,
        ]);
    }
    public function update(StoreMaintenanceRequest $request, string $id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $maintenance->update(($request->validated()));

        return response()->json([
            'message' => 'maintenance actualizado correctamente',
            'maintenance' => $maintenance
        ]);
    }
    public function destroy(Maintenance $maintenance)
    {
        //
    }
    public function getDeviceMaintenances($id)
    {
        $maintenance = Maintenance::with('devicesMaintenance')->findOrFail($id);

        $formattedData = $maintenance->devicesMaintenance->map(function ($item) {
            return [
                'id' => $item->id,
                // 'id_equipo' => $item->id_equipo,
                'equipo' => [
                    'id' => $item->id_equipo,
                    'tipo_dispositivo' => $item->device->deviceType->tipo_dispositivo,
                    'nombre_marca' => $item->device->brand->nombre_marca,
                    'nombre_modelo' => $item->device->model->nombre_modelo,
                ],
                'id_mantenimiento' => $item->id_mantenimiento,
                'serie' => $item->serie,
                'precio_mantenimiento_equipo' => $item->precio_mantenimiento_equipo,
                'motivo_mantenimiento' => $item->motivo_mantenimiento,
                'condiciones_fisicas' => $item->condiciones_fisicas,
                'detalles_equipo_extra' => $item->detalles_equipo_extra,
                'diagnostico_equipo' => $item->diagnostico_equipo,
                'estado_actual' => $item->estado_actual,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json($formattedData);
    }

}
