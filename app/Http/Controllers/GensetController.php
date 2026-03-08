<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Genset;

class GensetController extends Controller
{
    
public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
{
    $query = Genset::query();

    if ($request->filled('gen_numero')) {
        $query->where('gen_numero', 'like', $request->gen_numero . '%');
    }

    if ($request->filled('gen_medida')) {
        $query->where('gen_medida', $request->gen_medida);
    }

    if ($request->filled('gen_consumo')) {
        $query->where('gen_consumo', $request->gen_consumo);
    }

    if ($request->filled('gen_estado')) {
        $query->where('gen_estado', 'like', $request->gen_estado . '%');
    }

    $genset = $query->orderBy('gen_numero')
                     ->paginate(50)
                     ->withQueryString();

    return view('genset.gensetview', compact('genset'));
}


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
