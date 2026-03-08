<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Chassis;
use App\Http\Requests\ValidacionChassis;

class ChassisController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

        public function show(Request $request)
{
    $query = Chassis::query();

    if ($request->filled('chass_numero')) {
    $query->where('chass_numero', 'like', $request->chass_numero . '%');
}

if ($request->filled('chass_placa')) {
    $query->where('chass_placa', 'like', $request->chass_placa . '%');
}

if ($request->filled('chass_ejes')) {
    $query->where('chass_ejes', $request->chass_ejes);
}

if ($request->filled('chass_medida')) {
    $query->where('chass_medida', $request->chass_medida);
}

if ($request->filled('chass_estructura')) {
    $query->where('chass_estructura', 'like', $request->chass_estructura . '%');
}

if ($request->filled('chass_estado')) {
    $query->where('chass_estado', 'like', $request->chass_estado . '%');
}


    $chassis = $query->orderBy('chass_numero')->paginate(50
    )->withQueryString();

    return view('chassis.chassisview', compact('chassis'));
}


public function create()
{
    return view('chassis.chassiscreate');
}


public function store(ValidacionChassis $request)
{
    try {

        $data = $request->validated();

        Chassis::create($data);

        return redirect()
            ->route('chassis')
            ->with('mensaje', 'Chassis registrado correctamente');

    } catch (\Exception $e) {

        return redirect()
            ->route('chassis.create')
            ->with(
                'mensaje de error',
                'Hubo un problema al registrar el chassis. Por favor, intente nuevamente.'
            )
            ->withInput();
    }
}


public function edit($id)
{
    try {

        $chassis = Chassis::findOrFail($id);

        return view('chassis.chassisedit', compact('chassis'));

    } catch (\Exception $e) {

        return redirect()
            ->route('chassis')
            ->with(
                'mensaje de error',
                'El chassis que intenta editar no existe o fue eliminado.'
            );
    }
}



public function update(ValidacionChassis $request, Chassis $chassis)
{
    try {

        $data = $request->validated();

        $chassis->update($data);

        return redirect()
            ->route('chassis')
            ->with('mensaje', 'Chassis actualizado correctamente');

    } catch (\Exception $e) {

        return redirect()
            ->route('chassis.edit', $chassis->id)
            ->with(
                'mensaje de error',
                'Hubo un problema al actualizar el chassis. Por favor, intente nuevamente.'
            )
            ->withInput();
    }
}

public function destroy($id)
{
    try {

        $chassis = Chassis::findOrFail($id);
        $chassis->delete();

        return redirect()
            ->route('chassis')
            ->with('mensaje', 'Chassis eliminado correctamente');

    } catch (\Exception $e) {

        return redirect()
            ->route('chassis')
            ->with(
                'mensaje de error',
                'Hubo un problema al eliminar el chassis. Por favor, intente nuevamente.'
            );
    }
}


}

