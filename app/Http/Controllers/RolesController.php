<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function show(Request $request)
{

    $search = $request->input('search');

    $roles = Role::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->orderBy('id')
        ->paginate(10);
    return view('admin.roles.rolesview', compact('roles', 'search'));
}



    public function create()
    {
        $permisos = Permission::all();
        return view('admin.roles.rolescreate', compact('permisos'));
    }

    public function edit(Role $role)
    {
        $permisos = Permission::all();
        $role->load('permissions');

        return view('admin.roles.rolesedit', compact('role', 'permisos'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name'
    ], [
        'name.required' => 'El nombre del rol es obligatorio.',
        'name.unique' => 'Ya existe un rol con ese nombre. Por favor, elija otro.'
    ]);
    
    try {
        $role = Role::create($request->all());

        if ($request->has('permisos')) {
            $role->permissions()->sync($request->permisos);
        }

        return redirect()->route('roles')->with('mensaje', 'El Rol se creó con éxito');
    } catch (\Exception $e) {
        return redirect()->route('roles.create')->with('mensaje de error', 'Hubo un problema al crear el rol');
    }
}

public function update(Request $request, Role $role)
{
    $request->validate([
        'name' => 'required|unique:roles,name,' . $role->id,
    ], [
        'name.required' => 'El nombre del rol es obligatorio.',
        'name.unique' => 'Ya existe un rol con ese nombre. Por favor, elija otro.',
    ]);

    try {
        $role->update(['name' => $request->name]);
        $role->permissions()->sync($request->input('permisos', []));

        return redirect()->route('roles')->with('mensaje', 'El Rol se actualizó con éxito');
    } catch (\Exception $e) {
        return redirect()->route('roles.edit', $role)->with('mensaje de error', 'Hubo un problema al actualizar el rol');
    }
}


public function destroy($id)
{
    try {
        // Busca el producto por su ID
        $role = Role::find($id);

        // Verifica si el producto existe
        if (!$role) {
            return redirect()->route('roles')->withErrors(['error' => 'No pudimos encontrar el registro.']);
        }

        // Elimina el producto
        $role->delete();

        // Redirige con un mensaje de éxito
        return redirect()->route('roles')->with(["mensaje" => "Registro eliminado con éxito"]);
    } catch (\Illuminate\Database\QueryException $e) {
        // Maneja posibles errores de base de datos
        return redirect()->route('roles')->withErrors(['catch' => $e->getMessage()]);
    }
}

}
