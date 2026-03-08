<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Restaurantes;

class RestaurantesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

        public function show(Request $request)
{
    $search = $request->input('search');

    $restaurantes = Restaurantes::when($search, function ($query, $search) {
            return $query->where('rest_nombre', 'like', '%' . $search . '%')
                ->orWhere('rest_correo', 'like', '%' . $search . '%')
                ->orWhere('rest_horarios', 'like', '%' . $search . '%');
        })
        ->orderBy('rest_id')
        ->paginate(10);

    return view('restaurantes.restaurantesview', compact('restaurantes', 'search'));
}

    }

