<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeudaController extends Controller
{
    public function index()
    {
        return view('principal.deuda');
    }
}
