<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $servicioId = $this->route('servicio')?->id;

        return [
            'nombre' => 'required|string|max:100|unique:servicios,nombre,' . $servicioId,
            'descripcion' => 'nullable|string|max:255',
            'precio' => 'required|numeric|min:0.01',
            'tiempo_estimado' => 'nullable|integer|min:1|max:1440',
'estado' => 'sometimes|in:activo,inactivo,1,0',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.unique' => 'Ya existe otro servicio con este nombre.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio debe ser mayor a 0.',
            'estado.required' => 'Selecciona el estado del servicio.',
        ];
    }
}
