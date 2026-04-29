<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'placa' => 'required|string|max:10|unique:motos,placa',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|in:activo,inactivo,1,0',
        ];
    }

    public function messages(): array
    {
        return [
            'placa.required' => 'La placa es obligatoria.',
            'placa.unique' => 'Esa placa ya está registrada.',
            'cliente_id.required' => 'Selecciona un cliente.',
            'estado.required' => 'Selecciona el estado.',
        ];
    }
}

