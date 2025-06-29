<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceTask;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaintenanceTaskController extends Controller
{
    public function index()
    {
        $maintenanceTasks = MaintenanceTask::all();

        return response()->json($maintenanceTasks);
    }
    public function store(Request $request)
    {
        $maintenanceTask = MaintenanceTask::create([
            'id_equipo_mantenimiento' => $request->input('id_equipo_mantenimiento'),
            'tarea_mantenimiento' => $request->input('tarea_mantenimiento'),
            'estado' => false,
        ]);

        return response()->json([
            'message' => 'Tarea de mantenimiento creada correctamente',
            'maintenance_task' => $maintenanceTask
        ], 201);
    }
    public function show(MaintenanceTask $maintenanceTask)
    {
        //
    }
    public function update(Request $request, int $id)
    {
        // Validar solo los campos presentes en la solicitud
        $validatedData = $request->only(['estado', 'tarea_mantenimiento']); // Especifica los campos permitidos

        $maintenance_task = MaintenanceTask::findOrFail($id);

        // Actualizar solo los campos enviados
        $maintenance_task->update($validatedData);

        return response()->json([
            'message' => 'Tarea de mantenimiento actualizada correctamente',
            'maintenance_task' => $maintenance_task,
        ]);
    }


    public function destroy(int $id)
    {
        $maintenance_task = MaintenanceTask::findOrFail($id);
        $maintenance_task->delete();
        return response()->json([
            'message' => 'Tarea de Mantenimiento eliminado correctamente',
            'maintenance_task' => $maintenance_task,
        ]);
    }
}
