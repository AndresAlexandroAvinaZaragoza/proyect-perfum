<?php

namespace App\Http\Controllers;

use App\Models\Decant;
use Illuminate\Http\Request;

class DecantController extends Controller
{
    public function index()
    {
        $decants = Decant::all();
        return view('principal.decant', compact('decants'));
    }
}
