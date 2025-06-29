<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\DeviceMaintenanceController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\DeviceTypeController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\MaintenanceTaskController;
use App\Http\Controllers\ModelsController;
use App\Http\Controllers\Transactions\CrearMantenimientoController;
use App\Http\Controllers\Transactions\CrearTipoDispositivoMarcaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Authentication route for retrieving user information
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Define resource routes for CRUD operations on entities
Route::apiResource('entidades', EntityController::class);

// Define additional routes for entity-specific operations
Route::get('/entidades/identificacion/{identificacion}', [EntityController::class, 'buscarPorIdentificacion']);
Route::get('/entidades/consulta-dni/{dni}', [EntityController::class, 'obtenerInformacionDNI']);
Route::get('/entidades/consulta-ruc/{ruc}', [EntityController::class, 'obtenerInformacionRUC']);

// Define resource routes for CRUD operations on device types
Route::apiResource('tipoDispositivos', DeviceTypeController::class);
Route::get('tipo-dispositivo/{id}/marcas', [DeviceTypeController::class, 'marcasRelacionadasDispositivo']);

// Define resource routes for CRUD operations on brands
Route::apiResource('marcas', controller: BrandsController::class);
Route::get('marca/{id}/modelos', [BrandsController::class, 'modelosRelacionadosMarca']);

// Define resource routes for CRUD operations on brands
Route::apiResource(name: 'modelos', controller: ModelsController::class);

// Define resource routes for CRUD operations on device types
Route::apiResource('mantenimientos', MaintenanceController::class);
Route::get('mantenimientos/{id}/equipo-mantenimiento', [MaintenanceController::class, 'getDeviceMaintenances']);

// Define resource routes for CRUD operations on device types
Route::apiResource('equipos', DeviceController::class);

// Define resource routes for CRUD operations on device types
Route::apiResource('equiposMantenimiento', DeviceMaintenanceController::class);
Route::get('/equiposMantenimiento/{id}/tareas', [DeviceMaintenanceController::class, 'obtenerTareasPorIdMantenimiento']);


Route::apiResource('tareasMantenimiento', MaintenanceTaskController::class);


Route::post('crear-mantenimiento', [CrearMantenimientoController::class, 'crearMantenimiento']);

Route::post('crear-tipoDispositivoMarca', [CrearTipoDispositivoMarcaController::class, 'crearTipoDispositivoMarca']);

Route::get('crearFormatoExcel/{id}/{tipo}', [ExcelController::class, 'crearFormatoExcel']);
