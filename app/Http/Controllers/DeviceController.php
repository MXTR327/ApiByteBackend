<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceRequest;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        $equipos = Device::with('deviceType', 'brand', 'model')->get();

        // Transformar los datos para devolver solo lo necesario
        $equipos = $equipos->map(function ($equipo) {
            return [
                'id' => $equipo->id,
                'tipo_dispositivo' => [
                    'id' => $equipo->deviceType->id,
                    'nombre' => $equipo->deviceType->tipo_dispositivo,
                ],
                'marca' => [
                    'id' => $equipo->brand->id,
                    'nombre' => $equipo->brand->nombre_marca,
                ],
                'modelo' => [
                    'id' => $equipo->model->id,
                    'nombre' => $equipo->model->nombre_modelo,
                ],
            ];
        });

        return response()->json($equipos);
    }

    public function store(StoreDeviceRequest $request)
    {
        $equipo = Device::create($request->validated());

        // Transformar el dispositivo creado para devolver solo lo necesario
        $equipo = [
            'id' => $equipo->id,
            'tipo_dispositivo' => [
                'id' => $equipo->deviceType->id,
                'nombre' => $equipo->deviceType->tipo_dispositivo,
            ],
            'marca' => [
                'id' => $equipo->brand->id,
                'nombre' => $equipo->brand->nombre_marca,
            ],
            'modelo' => [
                'id' => $equipo->model->id,
                'nombre' => $equipo->model->nombre_modelo,
            ],
        ];

        return response()->json([
            'equipo' => $equipo
        ], 201);
    }

    public function show(string $id)
    {
        $equipo = Device::find($id);

        if (!$equipo) {
            return response()->json(['message' => 'Equipo no encontrado'], 404);
        }

        return response()->json($equipo);
    }

    public function update(StoreDeviceRequest $request, string $id)
    {
        $equipo = Device::findOrFail($id);

        $equipo->update($request->validated());

        return response()->json([
            'message' => 'Equipo actualizado correctamente',
            'equipo' => $equipo
        ]);
    }

    public function destroy(string $id)
    {
        $equipo = Device::find($id);

        if (!$equipo) {
            return response()->json(['message' => 'Equipo no encontrado'], 404);
        }

        $equipo->delete();
        return response()->json(['message' => 'Equipo eliminado correctamente']);
    }
}
