<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrabajadorRequest;
use App\Http\Requests\UpdateTrabajadorRequest;
use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function index(Request $request)
    {
        $query = Trabajador::withCount('lavados');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                  ->orWhere('ci', 'like', "%$buscar%")
                  ->orWhere('telefono', 'like', "%$buscar%");
            });
        }

        $trabajadores = $query->paginate(15)->withQueryString();
        $totalTrabajadores = Trabajador::count();

        return view('trabajadores.index', compact('trabajadores', 'totalTrabajadores'));
    }

    public function create()
    {
        return view('trabajadores.create');
    }

    public function store(StoreTrabajadorRequest $request)
    {
        $data = $request->validated();
        $data['estado'] = 1;

        Trabajador::create($data);

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador registrado correctamente.');
    }

    public function show(Trabajador $trabajador)
    {
        $trabajador->load(['lavados' => function ($query) {
            $query->latest('fecha')->take(10)->with(['moto', 'servicio', 'cliente']);
        }]);

        $totalLavados = $trabajador->lavados()->count();
        $ingresosGenerados = $trabajador->lavados()->sum('precio_total');
        $comisionesPendientes = $ingresosGenerados * ($trabajador->porcentaje_comision / 100);
        $ultimoLavado = $trabajador->lavados()->latest('fecha')->first();

        return view('trabajadores.show', compact(
            'trabajador',
            'totalLavados',
            'ingresosGenerados',
            'comisionesPendientes',
            'ultimoLavado'
        ));
    }

    public function edit(Trabajador $trabajador)
    {
        return view('trabajadores.edit', compact('trabajador'));
    }

    public function update(UpdateTrabajadorRequest $request, Trabajador $trabajador)
    {
        $trabajador->update($request->validated());

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador actualizado correctamente.');
    }

    public function destroy(Trabajador $trabajador)
    {
        if ($trabajador->lavados()->exists()) {
            return redirect()->route('trabajadores.index')
                ->with('error', 'No se puede eliminar el trabajador porque tiene lavados asignados.');
        }

        $trabajador->delete();

        return redirect()->route('trabajadores.index')
            ->with('success', 'Trabajador enviado a la papelera.');
    }

    public function papelera()
    {
        $trabajadores = Trabajador::onlyTrashed()
            ->withCount('lavados')
            ->paginate(15)
            ->withQueryString();

        return view('trabajadores.papelera', compact('trabajadores'));
    }
    
    public function restaurar($id)
    {
        $trabajador = Trabajador::onlyTrashed()->findOrFail($id);
        $trabajador->restore();

        return redirect()->route('trabajadores.papelera')
            ->with('success', 'Trabajador restaurado correctamente.');
    }

    public function forzarEliminar($id)
    {
        $trabajador = Trabajador::onlyTrashed()
            ->withCount('lavados')
            ->findOrFail($id);

        if ($trabajador->lavados_count > 0) {
            return redirect()->route('trabajadores.papelera')
                ->with('error', 'No se puede eliminar permanentemente porque tiene lavados en historial.');
        }

        $trabajador->forceDelete();

        return redirect()->route('trabajadores.papelera')
            ->with('success', 'Trabajador eliminado permanentemente.');
    }
}