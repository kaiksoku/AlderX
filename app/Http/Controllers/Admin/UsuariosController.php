<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Importa el controlador base de Laravel
use Illuminate\Http\Request;
use App\Models\User; // Importa el modelo de Usuario
use App\Models\Departamentos;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }

    public function index(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $email = $request->input('email');
        $rol = $request->input('rol');
        $departamento = $request->input('departamento');
        $recinto = $request->input('recinto');

        $usuarios = User::with(['Nombre_Departamento', 'Nombre_Recinto', 'roles'])
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->whereNotNull('password')
            ->where('password', '!=', '')
            ->when($id, fn($query, $id) => $query->where('id', $id))
            ->when($name, fn($query, $name) => $query->where('name', 'like', '%' . $name . '%'))
            ->when($email, fn($query, $email) => $query->where('email', 'like', '%' . $email . '%'))
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
            ->when($recinto, function ($query, $recinto) {
                return $query->whereHas('Nombre_Recinto', function ($q) use ($recinto) {
                    $q->where('reci_nombre', 'like', '%' . $recinto . '%');
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->appends($request->all());

        return view('admin.users.usuariosview', compact('usuarios'));
    }

    public function edit($id)
    {
        $roles = Role::all();
        $usuario = User::find($id);
        $departamentos = Departamentos::all();
        return view('admin.users.usuariosedit', compact('usuario', 'roles', 'departamentos'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'departamento' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Obtener el usuario por su ID
        $usuario = User::findOrFail($id);

        // Actualizar los datos del usuario
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->departamento = $request->departamento;

        // Actualizar la contraseña solo si se ha ingresado una nueva
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        // Actualizar el rol del usuario
        $usuario->roles()->sync([$request->role_id]);

        return redirect()->route('usuarios.index')->with('mensaje', 'Cambios actualizados correctamente.');
    }

    public function destroy($id)
    {
        try {
            // Busca el producto por su ID
            $usuario = User::find($id);
            $nombre = $usuario->name;
    
            // Verifica si el producto existe
            if (!$usuario) {
                return redirect()->route('usuarios.index')->withErrors(['error' => 'No pudimos encontrar el Usuario.']);
            }
    
            // Elimina el producto
            $usuario->delete();
    
            // Redirige con un mensaje de éxito
            return redirect()->route('usuarios.index')->with(["mensaje" => "El usuario  $nombre  ha sido eliminado con éxito"]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Maneja posibles errores de base de datos
            return redirect()->route('usuarios.index')->withErrors(['catch' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $usuario = User::find($id);
        return view('admin.users.usuariosdetalle', compact('usuario'));
    }
    
}




