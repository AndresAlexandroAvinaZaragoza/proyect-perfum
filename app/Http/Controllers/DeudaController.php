<?php

namespace App\Http\Controllers;

use App\Models\Deuda;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\DetalleVentaDecant;
use App\Models\InventarioDecants;
use App\Models\Marca;
use Illuminate\Support\Facades\DB;
use App\Models\Detalle_Venta;
use App\Models\User;
use App\Models\Perfume;
use App\Models\Inventario;
use App\Models\Cliente;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Decant;
use App\Models\AbonoRegistro;

class DeudaController extends Controller
{

    public function index(Request $request)
    {
        $query = Deuda::with([
            'cliente',
            'ultimoAbono.usuario'
        ]);

        // BUSCADOR
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->whereHas('cliente', function ($q2) use ($search) {

                    $q2->where('nombre', 'like', "%{$search}%");

                })

                ->orWhereHas('venta', function ($q2) use ($search) {

                    $q2->where('folio', 'like', "%{$search}%");

                });

            });
        }

        // FILTRO ESTATUS
        if ($request->filled('estatus')) {

            switch ($request->estatus) {

                case 'completado':

                    $query->where('estatus', 'Pagada');

                    break;

                case 'en_progreso':

                    $query->where('estatus', 'pendiente')
                        ->where('abonado', '>', 0);

                    break;

                case 'atrasado':

                    $query->where('estatus', 'pendiente')
                        ->where('abonado', 0);

                    break;
            }
        }

        $deudas = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('principal.deuda', compact('deudas'));
    }
    


    public function show($id)
    {
        $deuda = Deuda::with([
            'cliente',
            'abonos.usuario',
            'venta.detalles.perfume.marca',
            'venta.detallesDecants.decant.perfume.marca',
            'usuario'
        ])->findOrFail($id);

        return view('principal.detalleAbono', compact('deuda'));
    }
}
