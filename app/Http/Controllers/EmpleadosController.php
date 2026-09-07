<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Departamentos;
use App\Models\Recintos;
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
        $id = $request->input('id');
        $name = $request->input('name');
        $rol = $request->input('rol');
        $departamento = $request->input('departamento');

        $usuarios = User::with(['Nombre_Departamento', 'roles'])
            ->when($id, fn($query, $id) => $query->where('id', $id))
            ->when($name, fn($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->when($rol, function ($query, $rol) {
                return $query->whereHas('roles', function ($q) use ($rol) {
                    $q->where('name', 'like', '%' . $rol . '%');
                });
            })
            ->when($departamento, function ($query, $departamento) {
                return $query->whereHas('Nombre_Departamento', function ($q) use ($departamento) {
                    $q->where('dep_nombre', 'like', '%' . $departamento . '%');
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.users.empleados.empleadosview', compact('usuarios'));
    }

    public function create()
    {
        $roles = Role::where('name', 'Empleado')->get();
        $departamentos = Departamentos::all();
        $recintos = Recintos::all();
        return view('admin.users.empleados.empleadoscreate', compact('roles', 'departamentos', 'recintos'));
    }

    public function edit($id)
    {
        $usuario = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $departamentos = Departamentos::all();

        return view('admin.users.empleados.empleadosedit', compact('usuario', 'roles', 'departamentos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'departamento' => 'required|exists:departamentos,dep_id',
            'role_id' => 'required|exists:roles,id',
        ], [
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $usuario = User::findOrFail($id);
        $usuario->name = $request->name;
        $usuario->email = $request->filled('email') ? $request->email : null;
        $usuario->departamento = $request->departamento;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();
        $usuario->roles()->sync([$request->role_id]);

        return redirect()->route('empleados')->with('mensaje', 'Cambios actualizados correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'departamento' => 'required|exists:departamentos,dep_id',
            'recinto' => 'required|exists:recintos,reci_id',
        ]);

        $roleEmpleado = Role::where('name', 'Empleado')->firstOrFail();

        $user = User::create([
            'name' => $request->name,
            'email' => null,
            'password' => null,
            'departamento' => $request->departamento,
            'recinto' => $request->recinto,
        ]);

        $user->syncRoles([$roleEmpleado->name]);

        return redirect()->route('empleados')->with('mensaje', 'El empleado se creó con éxito.');
    }
}
