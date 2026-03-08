<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Departamentos;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $roles = Role::where('name', '!=', 'empleado')->get();
        $departamentos = Departamentos::all();
        return view('auth.register', compact('roles', 'departamentos'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'departamento' => $request->departamento,
        ]);

        $user->roles()->attach($request->role_id); // Asigna el rol seleccionado

        return redirect()->route('usuarios.index')->with('mensaje', 'El Usuario se creó con éxito.');

    }
}
