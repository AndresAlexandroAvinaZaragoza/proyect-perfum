<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class dashboardController extends Controller
{


    public function index()
    {
        $metricas = DB::table('vista_dashboard_metricas')->first();

        return view('dashboard', compact('metricas'));
    }
}
