<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMotoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $motoId = $this->route('moto')?->id;

        return [
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|in:activo,inactivo,1,0',
        ];
    }

    public function messages(): array
    {
        return [
            'marca.required' => 'La marca es obligatoria.',
            'modelo.required' => 'El modelo es obligatorio.',
            'cliente_id.required' => 'Selecciona un cliente.',
            'estado.required' => 'Selecciona el estado.',
        ];
    }
}

