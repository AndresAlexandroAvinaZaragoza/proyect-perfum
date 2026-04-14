<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deuda;
use App\Models\AbonoRegistro;

class RegistrarAbonoController extends Controller
{
    public function index(){
        return view('principal.abonos');
    }

    public function show($id)
    {
        $deuda = Deuda::with(['cliente', 'abonos'])->findOrFail($id);

        return view('principal.abonos', compact('deuda'));
    }


    public function store(Request $request)
    {
        // Obtener deuda primero
        $deuda = Deuda::findOrFail($request->deuda_id);

        // Validación correcta
        $request->validate([
            'deuda_id' => 'required|exists:deudas,id',
            'pago' => 'required|numeric|min:0.01|max:' . $deuda->faltante,
            'tipo_pago' => 'required|string|max:255',
        ]);

        // Validaciones extra
        if ($request->pago > $deuda->faltante) {
            return back()->with('error', 'El pago excede la deuda');
        }

        if ($deuda->estatus === 'Pagada') {
            return back()->with('error', 'La deuda ya ha sido pagada.');
        }

        // Crear abono
        $abono = new AbonoRegistro();
        $abono->deuda_id = $deuda->id;
        $abono->pago = $request->pago;
        $abono->tipo_pago = $request->tipo_pago;
        $abono->user_id = auth()->id();
        $abono->empresa_id = 1;
        $abono->save();

        // Actualizar deuda
        $deuda->abonado += $request->pago;
        $deuda->faltante -= $request->pago;

        if ($deuda->faltante <= 0) {
            $deuda->estatus = 'Pagada';
            $deuda->faltante = 0;
        }

        $deuda->save();

        return redirect()
            ->route('abonos.show', $deuda->id)
            ->with('success', 'Abono registrado exitosamente.');
    }
}
