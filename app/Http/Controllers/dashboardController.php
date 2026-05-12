<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class dashboardController extends Controller
{




    public function index()
    {
        // VISTAS PARA DASHBOARD
        $metricas = DB::table('vista_dashboard_metricas')->first();
        $ventasMes = DB::table('vista_ventas_mes')->first();
        $ventasSemanales = DB::table('vista_ventas_semanales')->get();
        $ganancias = null;
        $gananciasSemanales = collect();

        if(auth()->user()->rol == 'admin'){
            $ganancias = DB::table('vista_ganancias_final')->first();
            $gananciasSemanales = DB::table('vista_ganancias_semanales')->get();
        }


        // SI EL USUARIO NO ENVÍA FECHAS → USA SEMANA ACTUAL
        $inicio = request('inicio') ?? Carbon::now()->startOfWeek()->format('Y-m-d');
        $fin = request('fin') ?? Carbon::now()->endOfWeek()->format('Y-m-d');

        $reporteAbonos = DB::select("CALL reporte_abonos_rango(?, ?)", [$inicio, $fin]);
        $reporteVentas = DB::select("CALL reporte_ventas_semanales(?, ?)",[$inicio, $fin]);


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
        return view('dashboard', compact('metricas', 'reporteAbonos', 'inicio', 'fin', 'ventasUsuarios', 'ventasMes', 'ventasSemanales', 'ganancias', 'gananciasSemanales', 'reporteVentas'));
    }
}
