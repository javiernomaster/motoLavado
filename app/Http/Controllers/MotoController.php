<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMotoRequest;
use App\Http\Requests\UpdateMotoRequest;
use App\Models\Moto;
use App\Models\Cliente;
use Illuminate\Http\Request;

class MotoController extends Controller
{
    public function index(Request $request)
    {
        $query = Moto::with('cliente')->withCount('lavados');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('placa', 'like', "%$buscar%")
                  ->orWhere('marca', 'like', "%$buscar%");
            });
        }

        $motos = $query->orderBy('estado', 'desc')
                       ->paginate(15)
                       ->withQueryString();

        $totalMotos = Moto::count();

        return view('motos.index', compact('motos', 'totalMotos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('motos.create', compact('clientes'));
    }

    public function store(StoreMotoRequest $request)
    {
        $data = $request->validated();
        $data['estado'] = $data['estado'] == 'activo' ? 1 : 0;

        Moto::create($data);

        return redirect()->route('motos.index')
            ->with('success', 'Moto registrada correctamente.');
    }

    public function show(Moto $moto)
    {
        $totalLavados = $moto->lavados()->count();
        $ingresosGenerados = $moto->lavados()->sum('precio_total');

        $moto->load(['lavados' => function ($q) {
            $q->latest()->take(10)->with(['cliente', 'servicio']);
        }]);

        return view('motos.show', compact('moto', 'totalLavados', 'ingresosGenerados'));
    }

    public function edit(Moto $moto)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('motos.edit', compact('moto', 'clientes'));
    }

    public function update(UpdateMotoRequest $request, Moto $moto)
    {
        $data = $request->validated();
        $data['estado'] = $data['estado'] == 'activo' ? 1 : 0;

        $moto->update($data);

        return redirect()->route('motos.index')
            ->with('success', 'Moto actualizada correctamente.');
    }

    public function destroy(Moto $moto)
    {
        $moto->delete();

        return redirect()->route('motos.index')
            ->with('success', 'Moto enviada a la papelera.');
    }

    public function papelera()
    {
        $motos = Moto::onlyTrashed()
            ->with('cliente')
            ->withCount('lavados')
            ->paginate(15);

        return view('motos.papelera', compact('motos'));
    }

    
    public function restaurar($id)
    {
        $moto = Moto::onlyTrashed()->findOrFail($id);
        $moto->restore();

        return redirect()->route('motos.papelera')
            ->with('success', 'Moto restaurada correctamente.');
    }

  
    public function forzarEliminar($id)
    {
        $moto = Moto::onlyTrashed()->findOrFail($id);
        $moto->forceDelete();

        return redirect()->route('motos.papelera')
            ->with('success', 'Moto eliminada definitivamente.');
    }
}