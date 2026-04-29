<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServicioRequest;
use App\Http\Requests\UpdateServicioRequest;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $query = Servicio::withCount('lavados');

        if ($request->filled('buscar')) {
            $buscar = $request->input('buscar');
            $query->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%");
            });
        }

        $servicios = $query->orderBy('estado', 'desc')
            ->paginate(15)
            ->withQueryString();

        $totalServicios = Servicio::count();

        return view('servicios.index', compact('servicios', 'totalServicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(StoreServicioRequest $request)
    {
        $data = $request->validated();
        $data['estado'] = 1;

        Servicio::create($data);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio registrado correctamente.');
    }

    public function show(Servicio $servicio)
    {
        $totalLavados = $servicio->lavados()->count();
        $ingresosGenerados = $servicio->lavados()->sum('precio_total');

        $servicio->load(['lavados' => function ($query) {
            $query->take(10)->with(['cliente', 'moto']);
        }]);

        return view('servicios.show', compact(
            'servicio',
            'totalLavados',
            'ingresosGenerados'
        ));
    }

    public function edit(Servicio $servicio)
    {
        return view('servicios.edit', compact('servicio'));
    }

    public function update(UpdateServicioRequest $request, Servicio $servicio)
    {
        $data = $request->validated();
        $servicio->update($data);

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Servicio $servicio)
    {
        if ($servicio->lavados()->count() > 0) {
            return redirect()->route('servicios.index')
                ->with('error', 'No se puede eliminar porque tiene lavados asignados.');
        }

        $servicio->delete();

        return redirect()->route('servicios.index')
            ->with('success', 'Servicio enviado a la papelera.');
    }

   

    public function papelera()
    {
        $servicios = Servicio::onlyTrashed()
            ->withCount('lavados')
            ->paginate(15)
            ->withQueryString();

        return view('servicios.papelera', compact('servicios'));
    }

    // ❗ SIN MODEL BINDING (CLAVE DEL 404)
    public function restaurar($id)
    {
        $servicio = Servicio::onlyTrashed()->findOrFail($id);
        $servicio->restore();

        return redirect()->route('servicios.papelera')
            ->with('success', 'Servicio restaurado correctamente.');
    }

    
    public function forzarEliminar($id)
    {
        $servicio = Servicio::onlyTrashed()
            ->withCount('lavados')
            ->findOrFail($id);

        if ($servicio->lavados_count > 0) {
            return redirect()->route('servicios.papelera')
                ->with('error', 'No se puede eliminar permanentemente porque tiene lavados en historial.');
        }

        $servicio->forceDelete();

        return redirect()->route('servicios.papelera')
            ->with('success', 'Servicio eliminado permanentemente.');
    }
}