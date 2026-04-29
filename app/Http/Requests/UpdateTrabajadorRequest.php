<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrabajadorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $trabajadorId = $this->route('trabajador')?->id;

        return [
            'nombre' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:100',
            'ci' => 'required|string|regex:/^[0-9]{5,20}$/|unique:trabajadores,ci,' . $trabajadorId . '|max:20',
            'telefono' => 'nullable|string|regex:/^[0-9]{6,15}$/|max:20',
            'direccion' => 'nullable|string|max:255',
            'porcentaje_comision' => 'required|numeric|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'ci.required' => 'El CI es obligatorio.',
            'ci.regex' => 'El CI debe contener solo números (mínimo 5 dígitos).',
            'ci.unique' => 'Ya existe otro trabajador con este CI.',
            'telefono.regex' => 'El teléfono debe contener solo números (mínimo 6 dígitos).',
            'porcentaje_comision.min' => 'La comisión debe ser al menos 1%.',
            'porcentaje_comision.max' => 'La comisión no puede superar 100%.',
        ];
    }
}

