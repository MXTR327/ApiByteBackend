<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceTypeRequest;
use App\Http\Resources\DeviceTypeResource;
use App\Models\DeviceType;

class DeviceTypeController extends Controller
{
    public function index()
    {
        return DeviceTypeResource::collection(DeviceType::all());
    }

    public function store(StoreDeviceTypeRequest $request)
    {
        $tipo_dispositivo = DeviceType::create($request->validated());

        return response()->json([
            'tipo_dispositivo' => $tipo_dispositivo
        ], 201);
    }

    public function show(string $id)
    {
        $tipo_dispositivo = DeviceType::find($id);

        if (!$tipo_dispositivo) {
            return response()->json(['message' => 'Tipo dispositivo no encontrado'], 404);
        }

        return response()->json($tipo_dispositivo);
    }

    public function update(StoreDeviceTypeRequest $request, string $id)
    {
        $tipo_dispositivo = DeviceType::findOrFail($id);

        $tipo_dispositivo->update($request->validated());

        return response()->json([
            'message' => 'tipo_dispositivo actualizado correctamente',
            'tipo_dispositivo' => $tipo_dispositivo
        ]);
    }

    public function destroy(string $id)
    {
        $tipo_dispositivo = DeviceType::find($id);

        if (!$tipo_dispositivo) {
            return response()->json(['message' => 'Tipo_dispositivo no encontrado'], 404);
        }

        $tipo_dispositivo->delete();
        return response()->json(['message' => 'Tipo_dispositivo eliminado correctamente']);
    }

    public function marcasRelacionadasDispositivo($id)
    {
        $deviceType = DeviceType::with('brands')->findOrFail($id);

        return response()->json($deviceType->brands);
    }
}
