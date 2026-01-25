<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'categoria_id' => $this->categoria_id === '' ? null : $this->categoria_id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $servicio = $this->route('servicio');
        return [
            'codigo' => 'nullable|unique:servicios,codigo,'.$servicio->id.'|max:50',
            'codigosin' => 'nullable|string|max:255',
            'nombre' => 'required|unique:servicios,nombre,'.$servicio->id.'|max:255',
            'descripcion' => 'nullable|max:1000',
            'precio' => 'required|numeric|min:0',
            'presentacione_id' => 'required|integer|exists:presentaciones,id',
            'categoria_id' => 'nullable|integer|exists:categorias,id'
        ];
    }

    public function attributes()
    {
        return [
            'marca_id' => 'marca',
            'presentacione_id' => 'presentación',
            'categoria_id' => 'categoria',
            'codigosin' => 'código SIN'
        ];
    }

    public function messages()
    {
        return [
            //'codigo.required' => 'Se necesita un campo código'
        ];
    }
}
