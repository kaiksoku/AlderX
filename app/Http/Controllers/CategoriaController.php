<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria; // Importa el modelo Categoria

class CategoriaController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $search = $request->input('search');

    $categorias = Categoria::when($search, function ($query, $search) {
            return $query->where('cat_nombre', 'like', '%' . $search . '%');
        })
        ->orderBy('cat_id')
        ->paginate(10);

    return view('categoria.categoriaview', compact('categorias', 'search'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categoria.categoriacreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validar los datos de entrada
    $data = $request->validate([
        'cat_nombre' => 'required|string|max:25',
    ]);

    // Crear la categoría con los datos validados
    Categoria::create($data);

    return redirect()->route('categoria')->with('mensaje', 'Categoría registrada con éxito.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('categoria.categoriaedit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
