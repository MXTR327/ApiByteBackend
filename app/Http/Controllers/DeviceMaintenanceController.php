<?php

namespace App\Http\Controllers;

use App\Models\DeviceMaintenance;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeviceMaintenanceRequest;

class DeviceMaintenanceController extends Controller
{
    public function index()
    {

    }

    public function store(StoreDeviceMaintenanceRequest $request)
    {
        $device_maintenance = DeviceMaintenance::create($request->validated());

        return response()->json([
            'device_maintenance' => $device_maintenance
        ], 201);
    }

    public function show(DeviceMaintenance $deviceMaintenance)
    {
        //
    }

    public function update(StoreDeviceMaintenanceRequest $request, string $id)
    {
        $device_maintenance = DeviceMaintenance::findOrFail($id);

        $device_maintenance->update(($request->validated()));

        return response()->json([
            'message' => 'device_maintenance actualizado correctamente',
            'device_maintenance' => $device_maintenance
        ]);
    }

    public function destroy(DeviceMaintenance $deviceMaintenance)
    {
        //
    }

    public function obtenerTareasPorIdMantenimiento(string $id)
    {
        // Encuentra el mantenimiento por ID o lanza un error 404
        $deviceMaintenance = DeviceMaintenance::findOrFail($id);

        // Obtiene todas las tareas relacionadas
        $tasks = $deviceMaintenance->maintenanceTasks;

        // Retorna las tareas como respuesta JSON
        return response()->json($tasks);
    }
}
