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
use Illuminate\Validation\Rules\Password;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        // Si es empleado solo verá su usuario
        if (auth()->user()->rol === 'empleado') {
            $query->where('id', auth()->id());
        }

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

            //Validar usuario logeado
            if(!auth()->check()){
                abort(403, 'No autorizado');
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'usuario' => 'required|string|max:50|unique:users,usuario',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'rol' => 'required|string'
            ],[
                'email.unique' => 'El correo electrónico ya está en uso',
                'usuario.unique' => 'El nombre de usuario ya está en uso',
                'password.confirmed' => 'Las contraseñas no coinciden'
            ]);

            // Solo admin puede crear usuarios
            if(auth()->user()->rol !== 'admin'){
                abort(403, 'No autorizado');
            }


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
            'usuario' => 'required|string|max:50|unique:users,usuario,'.$usuario->id,
            'email' => 'required|email|max:255|unique:users,email,'.$usuario->id,
            'rol' => 'required|in:admin,empleado',

            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
            ],
        ],[
            'email.unique' => 'El correo electrónico ya está en uso',
            'usuario.unique' => 'El nombre de usuario ya está en uso',
            'password.confirmed' => 'Las contraseñas no coinciden'
        ]);

        // VERIFICAR CAMBIOS ANTES DE ACTUALIZAR
        $emailCambiado = $usuario->email !== $request->email;

        $passwordCambiado = $request->filled('password');

        // ACTUALIZAR DATOS
        $usuario->name = $request->name;
        $usuario->usuario = $request->usuario;
        $usuario->email = $request->email;

        // SOLO ADMIN CAMBIA ROL
        if(auth()->user()->rol === 'admin'){
            $usuario->rol = $request->rol;
        }

        // SI CAMBIÓ PASSWORD
        if($passwordCambiado){
            $usuario->password = Hash::make($request->password);
        }

        // SI CAMBIÓ EMAIL
        if($emailCambiado){
            $usuario->email_verified_at = null;

            // OPCIONAL:
            // $usuario->sendEmailVerificationNotification();
        }

        $usuario->save();

        // MENSAJES
        if($emailCambiado && $passwordCambiado){
            return back()->with(
                'success',
                'Correo y contraseña actualizados correctamente'
            );
        }

        if($emailCambiado){
            return back()->with(
                'success',
                'Correo actualizado correctamente, por favor verifica tu nuevo correo'
            );
        }

        if($passwordCambiado){
            return back()->with(
                'success',
                'Contraseña actualizada correctamente'
            );
        }

        return back()->with(
            'success',
            'Usuario actualizado correctamente'
        );
    }
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        $usuario->delete();

        return redirect()->back()->with('success', 'Usuario eliminado correctamente');
    }




}
