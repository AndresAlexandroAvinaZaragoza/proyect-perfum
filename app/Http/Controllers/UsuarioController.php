<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if($request->search){
            $query->where(function($q) use ($request){
                $q->where('name','like','%'.$request->search.'%')
                ->orWhere('usuario','like','%'.$request->search.'%')
                ->orWhere('email','like','%'.$request->search.'%');
            });
        }

        $usuarios = $query->paginate(10)->withQueryString();
        return view('principal.usuario', compact('usuarios'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request){
            $request->validate([
                'name' => 'required|string|max:255',
                'usuario' => 'required|string|max:50|unique:users,usuario',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'rol' => 'required|string'
            ]);

            User::create([
                'name' => $request->name,
                'usuario' => $request->usuario,
                'email' => $request->email,
                'rol' => $request->rol,
                'password' => Hash::make($request->password),
            ]);

            return back()->with('success', 'Usuario creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'usuario' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rol' => 'required|in:admin,empleado',
        ]);

        $usuario->name = $request->name;
        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;
        $usuario->rol = $request->rol;

        // Solo actualizar contraseña si se escribió algo
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'confirmed|min:6'
            ]);

            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->back()->with('success', 'Usuario actualizado correctamente');
    }
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        $usuario->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente');
    }




}
