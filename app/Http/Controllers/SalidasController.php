<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chassis;
use App\Models\Genset;

class SalidasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $chassis = Chassis::orderBy('chass_numero')->pluck('chass_numero');
        return view('operaciones.salidas.salidascreate', compact('chassis'));
    }

// Valida en el formulario de salida que el CHASSIS existe antes de dejar pasar --------------------------    
    public function validarChassis(Request $request)
{
    $request->validate([
        'chass_numero' => 'required|numeric'
    ]);

    $chassis = Chassis::where('chass_numero', $request->chass_numero)->first();

    if (!$chassis) {
        return response()->json([
            'status' => 'no_existe'
        ]);
    }

    if ($chassis->chass_estado === 'Taller') {
        return response()->json([
            'status' => 'taller'
        ]);
    }

    return response()->json([
        'status' => 'valido',
        'placa'  => $chassis->chass_placa // ajusta si el nombre es otro
    ]);
}

// Valida en el formulario de salida que el GENSET existe antes de dejar pasar --------------------------  
public function validarGenset(Request $request)
{
    $genset = Genset::where('gen_numero', $request->gen_numero)->first();

    if (!$genset) {
        return response()->json([
            'status' => 'no_existe'
        ]);
    }

    if ($genset->gen_estado === 'taller') {
        return response()->json([
            'status' => 'taller'
        ]);
    }

    return response()->json([
        'status' => 'valido'
    ]);
}


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
