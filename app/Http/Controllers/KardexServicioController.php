<?php

namespace App\Http\Controllers;

use App\Models\KardexServicio;
use App\Models\Servicio;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class KardexServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $servicio_id = $request->get('servicio_id');
        $servicios = Servicio::latest()->get();

        $kardexServicio = $servicio_id
            ? KardexServicio::where('servicio_id', $servicio_id)->latest()->get()
            : collect();

        return view('kardexServicio.index', compact('servicios', 'kardexServicio', 'servicio_id'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
