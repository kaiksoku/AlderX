<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departamentos;
use Illuminate\Support\Facades\Hash;

class DepartamentosController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        
    }

    public function show(Request $request)
    {
        $search = $request->input('search');

        $departamentos = Departamentos::when($search, function ($query, $search) {
             return $query->where('dep_nombre', 'like', '%' . $search . '%');
    })
    ->orderBy('dep_id')
    ->paginate(10);


        return view('admin.users.departamentos.departamentosview', compact('departamentos', 'search'));
    }

    public function create()
    {
        return view('admin.users.departamentos.departamentoscreate');
    }

    public function store(Request $request)
{
    // Validar los datos de entrada
    $data = $request->validate([
        'dep_nombre' => 'required|string|max:25',
    ]);

    // Crear la categoría con los datos validados
    Departamentos::create($data);

    return redirect()->route('departamentos')->with('mensaje', 'Departamento registrado con éxito.');
}

public function destroy($id)
{
    try {
        // Busca el producto por su ID
        $departamento = Departamentos::find($id);

        // Verifica si el producto existe
        if (!$departamento) {
            return redirect()->route('producto')->withErrors(['error' => 'El producto no existe.']);
        }

        // Elimina el producto
        $departamento->delete();

        // Redirige con un mensaje de éxito
        return redirect()->route('departamentos')->with(["mensaje" => "Departamento eliminado con éxito"]);
    } catch (\Illuminate\Database\QueryException $e) {
        // Maneja posibles errores de base de datos
        return redirect()->route('departamentos')->withErrors(['catch' => $e->getMessage()]);
    }
}


}
