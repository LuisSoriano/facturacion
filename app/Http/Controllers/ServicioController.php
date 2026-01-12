<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServicioRequest;
use App\Http\Requests\UpdateServicioRequest;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Presentacione;
use App\Models\Servicio;
use App\Services\ActivityLogService;
use App\Services\ServicioService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ServicioController extends Controller
{
    protected $servicioService;

    function __construct(ServicioService $servicioService)
    {
        $this->servicioService = $servicioService;
        $this->middleware('permission:ver-servicio|crear-servicio|editar-servicio|eliminar-servicio', ['only' => ['index']]);
        $this->middleware('permission:crear-servicio', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-servicio', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-servicio', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $servicios = Servicio::with([
            'categoria.caracteristica',
            'presentacione.caracteristica'
        ])
            ->latest()
            ->get();

        return view('servicio.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $presentaciones = Presentacione::join('caracteristicas as c', 'presentaciones.caracteristica_id', '=', 'c.id')
            ->select('presentaciones.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();
        // dd($presentaciones);
        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
            ->select('categorias.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();

        return view('servicio.create', compact('presentaciones', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServicioRequest $request): RedirectResponse
    {   
        //dd($request);
        try {
            $this->servicioService->crearServicio($request->validated());
            ActivityLogService::log('Creación de servicio', 'Servicios', $request->validated());
            return redirect()->route('servicios.index')->with('success', 'Servicio registrado');
        } catch (Throwable $e) {
            dd($e);
            Log::error('Error al crear el servicio', ['error' => $e->getMessage()]);
            return redirect()->route('servicios.index')->with('error', 'Ups, algo falló');
        }
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
    public function edit(Servicio $servicio): View
    {

        $presentaciones = Presentacione::join('caracteristicas as c', 'presentaciones.caracteristica_id', '=', 'c.id')
            ->select('presentaciones.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();

        $categorias = Categoria::join('caracteristicas as c', 'categorias.caracteristica_id', '=', 'c.id')
            ->select('categorias.id as id', 'c.nombre as nombre')
            ->where('c.estado', 1)
            ->get();

        return view('servicio.edit', compact('servicio', 'presentaciones', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServicioRequest $request, Servicio $servicio): RedirectResponse
    {
        try {
            $this->servicioService->editarServicio($request->validated(), $servicio);
            ActivityLogService::log('Edición de servicio', 'Servicios', $request->validated());
            return redirect()->route('servicios.index')->with('success', 'Servicio editado');
        } catch (Throwable $e) {
            Log::error('Error al editar el servicio', ['error' => $e->getMessage()]);
            return redirect()->route('servicios.index')->with('error', 'Ups, algo falló');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        /*
        $message = '';
        $servicio = Servicio::find($id);
        if ($servicio->estado == 1) {
            Servicio::where('id', $servicio->id)
                ->update([
                    'estado' => 0
                ]);
            $message = 'Servicio eliminado';
        } else {
            Servicio::where('id', $servicio->id)
                ->update([
                    'estado' => 1
                ]);
            $message = 'Servicio restaurado';
        }

        return redirect()->route('servicios.index')->with('success', $message);*/
    }
}
