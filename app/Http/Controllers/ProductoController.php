<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto; // Importa el modelo Producto
use App\Models\Categoria; // Importa el modelo categoria
use App\Http\Requests\ValidacionProducto;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $search = $request->input('search');

        $productos = Producto::with('categoria')
            ->when($search, function ($query, $search) {
                return $query->where('prod_nombre', 'like', '%' . $search . '%')
                    ->orWhere('prod_cantidad', 'like', '%' . $search . '%')
                    ->orWhere('prod_precio', 'like', '%' . $search . '%')
                    ->orWhereHas('categoria', function ($query) use ($search) {
                        $query->where('cat_nombre', 'like', '%' . $search . '%');
                    });
            })
            ->orderby('prod_id')
            ->paginate(10);

        return view('producto.productoview', compact('productos', 'search'));
    }






    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all(); 
        return view('producto.productocreate', compact('categorias'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    

    /**
     * Show the form for editing the specified resource.
     * 
     * 
     */

     public function store(ValidacionProducto $request)
    {
        
        $data = $request->validated();
        Producto::create($data);
        return redirect()->route('producto')->with('mensaje', 'Producto Registrado con Éxito.');
    }
     
    public function edit()
    {
        return view ('producto.productoedit');
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
    public function destroy($id)
{
    try {
        // Busca el producto por su ID
        $producto = Producto::find($id);

        // Verifica si el producto existe
        if (!$producto) {
            return redirect()->route('producto')->withErrors(['error' => 'El producto no existe.']);
        }

        // Elimina el producto
        $producto->delete();

        // Redirige con un mensaje de éxito
        return redirect()->route('producto')->with(["mensaje" => "Registro eliminado con éxito"]);
    } catch (\Illuminate\Database\QueryException $e) {
        // Maneja posibles errores de base de datos
        return redirect()->route('producto')->withErrors(['catch' => $e->getMessage()]);
    }
}


        
}

