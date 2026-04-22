<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // LISTAR CLIENTES
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    // FORMULARIO CREAR
    public function create()
    {
        return view('clientes.create');
    }

    // GUARDAR CLIENTE
    public function store(Request $request)
    {
        Cliente::create($request->all());
        return redirect()->route('clientes.index');
    }

    // EDITAR (lo veremos luego)
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // ACTUALIZAR
    public function update(Request $request, Cliente $cliente)
    {
        $cliente->update($request->all());
        return redirect()->route('clientes.index');
    }

    // ELIMINAR
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return back();
    }
}