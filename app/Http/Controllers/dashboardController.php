<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class dashboardController extends Controller
{




    public function index()
    {
        $metricas = DB::table('vista_dashboard_metricas')->first();

        // SI EL USUARIO NO ENVÍA FECHAS → USA SEMANA ACTUAL
        $inicio = request('inicio') ?? Carbon::now()->startOfWeek()->format('Y-m-d');
        $fin = request('fin') ?? Carbon::now()->endOfWeek()->format('Y-m-d');

        $reporte = DB::select("CALL reporte_abonos_rango(?, ?)", [$inicio, $fin]);
        
        // para procedimiento de ventas por usuario
        if(auth()->user()->rol == 'admin'){
            $ventasUsuarios = DB::select("
                SELECT 
                    u.name AS usuario,
                    COUNT(v.id) AS total_ventas,
                    SUM(v.total) AS total_ingresos
                FROM ventas v
                JOIN users u ON v.user_id = u.id
                GROUP BY u.name
            ");
        }else{
            $ventasUsuarios = DB::select("CALL reporte_ventas_por_usuario(?)", [
                auth()->id()
            ]);
        }
        return view('dashboard', compact('metricas', 'reporte', 'inicio', 'fin', 'ventasUsuarios'));
    }
}
