<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clienteId = $this->route('cliente')->id;

        return [
            'nombre' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:255',
            'ci' => 'required|string|regex:/^[0-9]{5,20}$/|max:20|unique:clientes,ci,' . $clienteId,
            'telefono' => 'nullable|string|regex:/^[0-9]{6,15}$/|max:20',
            'direccion' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'ci.required' => 'El CI es obligatorio.',
            'ci.regex' => 'El CI debe contener solo números (mínimo 5 dígitos).',
            'ci.unique' => 'Ya existe otro cliente con este CI.',
            'telefono.regex' => 'El teléfono debe contener solo números (mínimo 6 dígitos).',
        ];
    }
}

