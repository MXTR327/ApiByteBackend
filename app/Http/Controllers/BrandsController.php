<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Http\Resources\BrandsResource;
use App\Http\Requests\StoreBrandRequest;

class BrandsController extends Controller
{
    public function index()
    {
        return BrandsResource::collection(Brands::all());
    }

    public function store(StoreBrandRequest $request)
    {
        $marca = Brands::create($request->validated());

        return response()->json([
            'marca' => $marca
        ], 201);
    }

    public function show(string $id)
    {
        $marca = Brands::findOrFail($id);

        return response()->json($marca);
    }

    public function update(StoreBrandRequest $request, string $id)
    {
        $marca = Brands::findOrFail($id);

        $marca->update($request->validated());

        return response()->json([
            'message' => 'Marca actualizada correctamente',
            'marca' => $marca
        ]);
    }
    public function destroy(string $id)
    {
        $marca = Brands::findOrFail($id);

        $marca->delete();

        return response()->json(['message' => 'Marca eliminada correctamente']);
    }
    public function modelosRelacionadosMarca($id)
    {
        $brands = Brands::with('models')->findOrFail($id);

        return response()->json($brands->models);
    }
}
