<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConfiguracionSiatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nit' => 'required|string|max:20',
            'razon_social' => 'required|string|max:255',
            'codigo_sistema' => 'required|string|max:100',
            'nombre_sistema' => 'required|string|max:255',
            'codigo_ambiente' => 'required|integer|in:1,2',
            'codigo_modalidad' => 'required|integer|in:1,2',
            'codigo_sucursal' => 'required|integer',
            'codigo_punto_venta' => 'required|integer',
            'cuis' => 'nullable|string|max:20',
            'token_api' => 'nullable|string',
            'url_sincronizacion' => 'nullable|url',
            'url_operaciones' => 'nullable|url',
            'url_codigos' => 'nullable|url',
            'url_facturacion' => 'nullable|url',
        ];
    }
}