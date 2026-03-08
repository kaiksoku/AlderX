<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Departamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpleadosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        
    }
    
    public function show(Request $request)
    {
        $search = $request->input('search');

        $usuarios = User::with(['Nombre_Departamento', 'roles']) 
            ->when($search, function ($query, $search) {
             return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
    })
    ->orderBy('id')
    ->paginate(10);


        return view('admin.users.empleados.empleadosview', compact('usuarios', 'search'));
    }

    public function create()
    {
        $roles = Role::all();
        $departamentos = Departamentos::all();
        return view('admin.users.empleados.empleadoscreate', compact('roles', 'departamentos'));
    }

    public function store(Request $request)
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

        return redirect()->route('solicitudes')->with('mensaje', 'El Vale se creó con éxito.');


    }
}
