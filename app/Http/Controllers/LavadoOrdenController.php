<?php

namespace App\Http\Controllers;

use App\Models\LavadoOrden;
use App\Models\LavadoEstadoHistorial;
use App\Models\Cliente;
use App\Models\Moto;
use App\Models\Servicio;
use App\Models\Trabajador;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class LavadoOrdenController extends Controller
{
    protected array $estadosPermitidos = ['Pendiente', 'En proceso', 'Finalizado'];

    protected array $transicionesValidas = [
        'Pendiente' => ['En proceso', 'Finalizado'],
        'En proceso' => ['Finalizado'],
        'Finalizado' => [],
    ];

    protected array $metodosPago = ['efectivo', 'qr', 'efectivo/qr'];

    // LISTADO CON FILTROS, PAGINACIÓN Y TOTALES
    public function index(Request $request)
    {
        $query = LavadoOrden::with(['cliente', 'moto', 'servicio', 'trabajador']);

        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->cliente . '%');
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('desde') && $request->filled('hasta')) {
            $query->whereBetween('fecha', [$request->desde, $request->hasta]);
        }

        $totalFiltrado = (clone $query)->sum('precio_total');
        $totalPagado = (clone $query)->sum('monto_pagado');
        $cantidadFiltrada = (clone $query)->count();

        $lavados = $query->orderBy('fecha', 'desc')->paginate(15)->withQueryString();

        return view('lavados.index', compact('lavados', 'totalFiltrado', 'totalPagado', 'cantidadFiltrada'));
    }

    // CREAR
    public function create(Request $request)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $motos = Moto::with('cliente')->orderBy('placa')->get();
        $servicios = Servicio::where('estado', 1)->orderBy('nombre')->get();
        $trabajadores = Trabajador::where('estado', 1)->orderBy('nombre')->get();
        $clientePreseleccionado = $request->query('cliente_id');

        return view('lavados.create', compact('clientes', 'motos', 'servicios', 'trabajadores', 'clientePreseleccionado'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'moto_id' => [
                'required',
                Rule::exists('motos', 'id')->where(function ($query) use ($request) {
                    $query->where('cliente_id', $request->cliente_id);
                }),
            ],
            'servicio_id' => [
                'required',
                Rule::exists('servicios', 'id')->where('estado', 1),
            ],
            'trabajador_id' => [
                'required',
                Rule::exists('trabajadores', 'id')->where('estado', 1),
            ],
            'fecha' => 'nullable|date',
        ], [
            'moto_id.exists' => 'La moto seleccionada no pertenece al cliente elegido.',
            'servicio_id.exists' => 'El servicio seleccionado no existe o no está activo.',
            'trabajador_id.exists' => 'El trabajador seleccionado no existe o no está activo.',
        ]);

        $servicio = Servicio::findOrFail($request->servicio_id);

        if (is_null($servicio->precio) || $servicio->precio <= 0) {
            return back()->withInput()->withErrors([
                'servicio_id' => 'El servicio seleccionado no tiene un precio válido.',
            ]);
        }

        $precioTotal = (float) $servicio->precio;

        $lavado = LavadoOrden::create([
            'fecha' => $request->fecha ?? Carbon::today(),
            'estado' => 'Pendiente',
            'cliente_id' => $request->cliente_id,
            'moto_id' => $request->moto_id,
            'servicio_id' => $request->servicio_id,
            'trabajador_id' => $request->trabajador_id,
            'precio_total' => $precioTotal,
            'monto_pagado' => 0,
            'saldo' => $precioTotal,
            'metodo_pago' => null,
            'estado_pago' => 'pendiente',
        ]);

        $this->registrarHistorial($lavado, null, $lavado->estado, 'Lavado creado');

        return redirect()->route('lavados.index')->with('success', 'Lavado registrado correctamente.');
    }

    // MOSTRAR
    public function show(LavadoOrden $lavado)
    {
        $lavado->load(['cliente', 'moto', 'servicio', 'trabajador', 'historial.user']);
        return view('lavados.show', compact('lavado'));
    }

    // EDITAR
    public function edit(LavadoOrden $lavado)
    {
        $lavado->load(['cliente', 'moto', 'servicio', 'trabajador']);

        $clientes = Cliente::orderBy('nombre')->get();
        $motos = Moto::with('cliente')->orderBy('placa')->get();
        $servicios = Servicio::orderBy('nombre')->get();
        $trabajadores = Trabajador::orderBy('nombre')->get();

        $transiciones = $this->transicionesValidas[$lavado->estado] ?? [];

        return view('lavados.edit', compact('lavado', 'clientes', 'motos', 'servicios', 'trabajadores', 'transiciones'));
    }

    public function update(Request $request, LavadoOrden $lavado)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'moto_id' => [
                'required',
                'exists:motos,id',
                Rule::exists('motos', 'id')->where(function ($query) use ($request) {
                    $query->where('cliente_id', $request->cliente_id);
                }),
            ],
            'servicio_id' => 'required|exists:servicios,id',
            'trabajador_id' => 'required|exists:trabajadores,id',
            'fecha' => 'required|date',
            'estado' => [
                'required',
                'string',
                'in:Pendiente,En proceso,Finalizado',
                function ($attribute, $value, $fail) use ($lavado) {
                    if ($value !== $lavado->estado && !in_array($value, $this->transicionesValidas[$lavado->estado] ?? [])) {
                        $fail("No se puede cambiar de '{$lavado->estado}' a '{$value}'. Transición no permitida.");
                    }
                },
            ],
        ], [
            'moto_id.exists' => 'La moto seleccionada no pertenece al cliente elegido.',
        ]);

        $estadoAnterior = $lavado->estado;

        $servicio = Servicio::findOrFail($request->servicio_id);
        $precioTotal = (float) $servicio->precio;

        $lavado->update([
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'cliente_id' => $request->cliente_id,
            'moto_id' => $request->moto_id,
            'servicio_id' => $request->servicio_id,
            'trabajador_id' => $request->trabajador_id,
            'precio_total' => $precioTotal,
        ]);

        if ($estadoAnterior !== $request->estado) {
            $this->registrarHistorial($lavado, $estadoAnterior, $request->estado);

            if ($request->estado === 'Finalizado') {
                $lavado->load(['cliente', 'moto', 'servicio']);
                (new WhatsAppService())->notificarLavadoFinalizado($lavado);
            }
        }

        return redirect()->route('lavados.index')->with('success', 'Lavado actualizado correctamente.');
    }

    // CAMBIAR ESTADO RÁPIDO (desde el listado)
    public function cambiarEstado(Request $request, LavadoOrden $lavado)
    {
        $request->validate([
            'estado' => [
                'required',
                'in:Pendiente,En proceso,Finalizado',
                function ($attribute, $value, $fail) use ($lavado) {
                    if ($value !== $lavado->estado && !in_array($value, $this->transicionesValidas[$lavado->estado] ?? [])) {
                        $fail("Transición no permitida.");
                    }
                },
            ],
        ]);

        $estadoAnterior = $lavado->estado;
        $nuevoEstado = $request->estado;

        $lavado->update(['estado' => $nuevoEstado]);

        $this->registrarHistorial($lavado, $estadoAnterior, $nuevoEstado, 'Cambio rápido desde listado');

        if ($nuevoEstado === 'Finalizado') {
            $lavado->load(['cliente', 'moto', 'servicio']);
            (new WhatsAppService())->notificarLavadoFinalizado($lavado);
        }

        return redirect()->route('lavados.index')->with('success', "Estado actualizado a '{$nuevoEstado}'.");
    }

    // ELIMINAR (Soft Delete)
    public function destroy(LavadoOrden $lavado)
    {
        $this->registrarHistorial($lavado, $lavado->estado, 'Eliminado', 'Lavado eliminado (soft delete)');
        $lavado->delete();

        return redirect()->route('lavados.index')->with('success', 'Lavado eliminado correctamente.');
    }

    // PAPELERA
    public function papelera()
    {
        $lavados = LavadoOrden::onlyTrashed()
            ->with(['cliente', 'moto', 'servicio', 'trabajador'])
            ->orderBy('deleted_at', 'desc')
            ->paginate(15);

        return view('lavados.papelera', compact('lavados'));
    }

    public function restaurar($id)
    {
        $lavado = LavadoOrden::withTrashed()->findOrFail($id);
        $lavado->restore();

        $this->registrarHistorial($lavado, 'Eliminado', $lavado->estado, 'Lavado restaurado desde papelera');

        return redirect()->route('lavados.papelera')->with('success', 'Lavado restaurado correctamente.');
    }

    public function forzarEliminar($id)
    {
        $lavado = LavadoOrden::withTrashed()->findOrFail($id);
        $lavado->forceDelete();

        return redirect()->route('lavados.papelera')->with('success', 'Lavado eliminado permanentemente.');
    }

    // HISTORIAL
    public function historial(LavadoOrden $lavado)
    {
        $historial = LavadoEstadoHistorial::with('user')
            ->where('lavado_orden_id', $lavado->id_orden)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('lavados.historial', compact('lavado', 'historial'));
    }

    // COBRAR
    public function formCobrar(LavadoOrden $lavado)
    {
        $lavado->load(['cliente', 'moto', 'servicio']);
        return view('lavados.cobrar', compact('lavado'));
    }

    public function cobrar(Request $request, LavadoOrden $lavado)
    {
        if ($lavado->saldo <= 0) {
            return redirect()->route('lavados.index')->with('info', 'El lavado #' . $lavado->id_orden . ' ya está saldado.');
        }

        $rules = [
            'metodo_pago' => 'required|in:efectivo,qr,efectivo/qr',
        ];

        if ($request->metodo_pago === 'efectivo/qr') {
            $rules['monto_efectivo'] = 'nullable|numeric|min:0';
            $rules['monto_qr'] = 'nullable|numeric|min:0';
        } else {
            $rules['monto_abono'] = 'required|numeric|min:0.01|max:' . $lavado->saldo;
        }

        $messages = [
            'monto_abono.required' => 'Debes ingresar un monto.',
            'monto_abono.min' => 'El monto debe ser mayor a 0.',
            'monto_abono.max' => 'El abono no puede superar el saldo pendiente de Bs. ' . number_format($lavado->saldo, 2) . '.',
            'metodo_pago.required' => 'Selecciona un método de pago.',
            'metodo_pago.in' => 'Método de pago no válido.',
        ];

        $request->validate($rules, $messages);

        if ($request->metodo_pago === 'efectivo/qr') {
            $montoAbono = (float) ($request->monto_efectivo ?? 0) + (float) ($request->monto_qr ?? 0);
            if ($montoAbono <= 0 || $montoAbono > $lavado->saldo) {
                return back()->withInput()->withErrors([
                    'monto_efectivo' => 'La suma de efectivo + QR debe ser mayor a 0 y no superar el saldo pendiente.',
                ]);
            }
        } else {
            $montoAbono = (float) $request->monto_abono;
        }

        $nuevoMontoPagado = $lavado->monto_pagado + $montoAbono;
        $saldo = max(0, $lavado->precio_total - $nuevoMontoPagado);

        $estadoPago = 'pendiente';
        if ($nuevoMontoPagado >= $lavado->precio_total) {
            $estadoPago = 'pagado';
        } elseif ($nuevoMontoPagado > 0) {
            $estadoPago = 'parcial';
        }

        $estadoAnterior = $lavado->estado;
        $nuevoEstado = $estadoAnterior;

        if ($saldo <= 0 && $lavado->estado !== 'Finalizado') {
            $nuevoEstado = 'Finalizado';
        }

        $metodoPagoFinal = $request->metodo_pago;
        if ($lavado->metodo_pago && $lavado->metodo_pago !== 'efectivo/qr' && $lavado->metodo_pago !== $request->metodo_pago) {
            $metodoPagoFinal = 'efectivo/qr';
        }

        $updateData = [
            'monto_pagado' => $nuevoMontoPagado,
            'saldo' => $saldo,
            'metodo_pago' => $metodoPagoFinal,
            'estado_pago' => $estadoPago,
        ];

        if ($nuevoEstado !== $estadoAnterior) {
            $updateData['estado'] = $nuevoEstado;
        }

        $lavado->update($updateData);

        $observacion = 'Cobro de Bs. ' . number_format($montoAbono, 2) . ' vía ' . $request->metodo_pago;
        if ($nuevoEstado !== $estadoAnterior) {
            $observacion .= ' (Pago completado → Lavado finalizado)';
        }
        $this->registrarHistorial($lavado, $estadoAnterior, $nuevoEstado, $observacion);

        if ($nuevoEstado === 'Finalizado') {
            $lavado->load(['cliente', 'moto', 'servicio']);
            (new WhatsAppService())->notificarLavadoFinalizado($lavado);
        }

        if ($saldo <= 0) {
            return redirect()->route('lavados.index')->with('success', '¡Pago completado! Lavado #' . $lavado->id_orden . ' finalizado y saldado.');
        }

        return redirect()->route('lavados.index')->with('success', 'Cobro registrado. Saldo restante: Bs. ' . number_format($saldo, 2));
    }

    // AUXILIARES
    private function registrarHistorial(LavadoOrden $lavado, ?string $anterior, string $nuevo, ?string $observacion = null): void
    {
        LavadoEstadoHistorial::create([
            'lavado_orden_id' => $lavado->id_orden,
            'estado_anterior' => $anterior,
            'estado_nuevo' => $nuevo,
            'user_id' => Auth::id(),
            'observacion' => $observacion,
        ]);
    }
}
