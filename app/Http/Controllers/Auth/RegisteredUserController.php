<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'usuario' => ['required', 'string', 'max:50', 'unique:users,usuario'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol' => ['required', 'in:admin,empleado'],
        ]);

        // Usar transacción para garantizar integridad de datos
        $user = DB::transaction(function () use ($request) {
            // Verificar si la empresa 'Perfum Intense' ya existe
            $empresa = Empresa::where('nombre_empresa', 'Perfum Intense')->first();
            
            // Si no existe, crearla
            if (!$empresa) {
                $empresa = Empresa::create([
                    'nombre_empresa' => 'Perfum Intense',
                    'plan' => 'premium',
                    'estatus' => 'activo',
                    'registro_fecha' => now(),
                ]);
            }

            // Crear el usuario con la empresa_id
            $user = User::create([
                'name' => $request->name,
                'usuario' => $request->usuario,
                'email' => $request->email,
                'rol' => $request->rol,
                'empresa_id' => $empresa->id,
                'password' => Hash::make($request->password),
            ]);

            return $user;
        });

        event(new Registered($user));

        return back()->with('success', 'Usuario creado correctamente');
    }
}
