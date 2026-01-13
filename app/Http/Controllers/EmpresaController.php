<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmpresaRequest;
use App\Http\Requests\UpdateConfiguracionSiatRequest;
use App\Models\Empresa;
use App\Models\ConfiguracionSiat;
use App\Models\Moneda;
use App\Services\ActivityLogService;
use App\Services\EmpresaService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $empresa = Empresa::with('configuracionSiat')->first();
        $monedas = Moneda::all();
        return view('empresa.index', compact('empresa', 'monedas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmpresaRequest $request, Empresa $empresa, EmpresaService $empresaService): RedirectResponse
    {
        try {
            $empresa->update($request->validated());
            $empresaService->limpiarCacheEmpresa();
            ActivityLogService::log('Edición de empresa', 'Empresa', $request->validated());
            return redirect()->route('empresa.index')->with('success', 'Institución editada');
        } catch (Throwable $e) {
            Log::error('Error al editar la empresa', ['error' => $e->getMessage()]);
            return redirect()->route('empresa.index')->with('error', 'Ups, algo falló');
        }
    }

    public function updateSiat(UpdateConfiguracionSiatRequest $request, Empresa $empresa): RedirectResponse
    {
        try {
            $empresa->configuracionSiat()->updateOrCreate(
                ['empresa_id' => $empresa->id],
                $request->validated()
            );
            ActivityLogService::log('Edición de configuración SIA', 'ConfiguracionSiat', $request->validated());
            return redirect()->route('empresa.index')->with('success', 'Configuración SIA editada');
        } catch (Throwable $e) {
            Log::error('Error al editar la configuración SIA', ['error' => $e->getMessage()]);
            return redirect()->route('empresa.index')->with('error', 'Ups, algo falló');
        }
    }

    public function testSiatConnection(Empresa $empresa): \Illuminate\Http\JsonResponse
    {
        try {
            $config = $empresa->configuracionSiat;
            if (!$config) {
                return response()->json(['status' => 'error', 'message' => 'Configuración SIA no encontrada']);
            }

            $url = $config->url_sincronizacion ?? config('siat.urls.sincronizacion');
            $token = $config->token_api ?? config('siat.token');

            // Configurar SoapClient con header apikey
            $options = [
                'trace' => true,
                'exceptions' => true,
                'connection_timeout' => 10,
                'stream_context' => stream_context_create([
                    'http' => [
                        'header' => 'apikey: ' . $token
                    ]
                ])
            ];

            $client = new \SoapClient($url, $options);

            // Usar verificarComunicacion que requiere autenticación básica
            $response = $client->verificarComunicacion();

            // Verificar que la respuesta indique comunicación exitosa
            if (isset($response->return->transaccion) && $response->return->transaccion == true) {
                // Verificar código de respuesta 926 (COMUNICACION EXITOSA)
                if (isset($response->return->mensajesList->codigo) && $response->return->mensajesList->codigo == 926) {
                    return response()->json(['status' => 'success', 'message' => 'Conectado - Comunicación exitosa']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Desconectado - Código de respuesta inválido']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Desconectado - Transacción fallida']);
            }
        } catch (\SoapFault $e) {
            return response()->json(['status' => 'error', 'message' => 'Desconectado - Datos incorrectos: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Desconectado: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
