<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistrarAbonoController extends Controller
{
    public function index()
    {
        return view('principal.abonos');
    }
}
