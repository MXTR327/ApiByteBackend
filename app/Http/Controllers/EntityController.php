<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntityRequest;
use App\Models\Entity;
use GuzzleHttp\Client;
use App\Http\Resources\EntityResource;
use GuzzleHttp\Exception\RequestException;

class EntityController extends Controller
{
    public function index()
    {
        return EntityResource::collection(Entity::all());
    }
    public function store(StoreEntityRequest $request)
    {
        $entidad = Entity::create($request->validated());

        return response()->json([
            'entidad' => $entidad
        ], 201);
    }
    public function show(string $id)
    {
        $entidad = Entity::find($id);

        if (!$entidad) {
            return response()->json(['message' => 'Entidad no encontrada'], 404);
        }

        return response()->json($entidad);
    }
    public function update(StoreEntityRequest $request, string $id)
    {
        $entidad = Entity::findOrFail($id);

        $entidad->update(($request->validated()));

        return response()->json([
            'message' => 'entidad actualizada correctamente',
            'entidad' => $entidad
        ]);
    }
    public function destroy(string $id)
    {
        $entidad = Entity::findOrFail($id);
        $entidad->delete();
        return response()->json(['message' => 'Entidad eliminada correctamente']);
    }
    public function buscarPorIdentificacion(string $identificacion)
    {
        try {
            $entidad = Entity::where('identificacion_entidad', $identificacion)->first();
            if ($entidad) {
                return response()->json($entidad);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Error de consulta a la base de datos
            return response()->json(['message' => 'Error en la base de datos', 'error' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            // Manejo general de otros errores
            return response()->json(['message' => 'Error interno del servidor', 'error' => $e->getMessage()], 500);
        }
    }
    public function obtenerInformacionDNI(string $dni)
    {
        $token = 'apis-token-10055.DKxuoTmD6FiZclBu5z5oj1jt8n6Km-BX'; // Coloca aquí tu token
        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);

        try {
            $response = $client->request('GET', '/v2/reniec/dni', [
                'http_errors' => false,
                'connect_timeout' => 5,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Referer' => 'https://apis.net.pe/api-consulta-dni',
                    'User-Agent' => 'laravel/guzzle',
                    'Accept' => 'application/json',
                ],
                'query' => ['numero' => $dni]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return response()->json($data);
        } catch (RequestException $e) {
            return response()->json(['error' => 'Error al realizar la consulta'], 500);
        }
    }
    public function obtenerInformacionRUC(string $ruc)
    {
        $token = 'apis-token-10055.DKxuoTmD6FiZclBu5z5oj1jt8n6Km-BX'; // Coloca aquí tu token
        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);

        try {
            $response = $client->request('GET', '/v2/sunat/ruc', [
                'http_errors' => false,
                'connect_timeout' => 5,
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Referer' => 'http://apis.net.pe/api-ruc',
                    'User-Agent' => 'laravel/guzzle',
                    'Accept' => 'application/json',
                ],
                'query' => ['numero' => $ruc]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return response()->json($data);
        } catch (RequestException $e) {
            return response()->json(['error' => 'Error al realizar la consulta'], 500);
        }
    }
}
