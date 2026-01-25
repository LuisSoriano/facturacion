<?php

namespace App\Services;

use App\Models\Servicio;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ServicioService
{
    /**
     * Crear un Registro
     */
    public function crearServicio(array $data): Servicio
    {
        $servicio = Servicio::create([
            'codigo' => $data['codigo'],
            'codigosin' => $data['codigosin'] ?? null,
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
            'categoria_id' => $data['categoria_id'],
            'presentacione_id' => $data['presentacione_id'],
        ]);

        return $servicio;
    }

    /**
     * Editar un registro
     */
    public function editarServicio(array $data, Servicio $servicio): Servicio
    {

        $servicio->update([
            'codigo' => $data['codigo'],
            'codigosin' => $data['codigosin'] ?? null,
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
            'categoria_id' => $data['categoria_id'],
            'presentacione_id' => $data['presentacione_id'],
        ]);

        return $servicio;
    }


    /**
     * Guarda una imagen en el Storage
     * 
     */
    private function handleUploadImage(UploadedFile $image, $img_path = null): string
    {
        if ($img_path) {
            $relative_path = str_replace('storage/', '', $img_path);

            if (Storage::disk('public')->exists($relative_path)) {
                Storage::disk('public')->delete($relative_path);
            }
        }

        $name = uniqid() . '.' . $image->getClientOriginalExtension();
        $path = 'storage/' . $image->storeAs('servicios', $name);
        return $path;
    }
}
