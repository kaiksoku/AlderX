<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chassis;
use App\Models\Genset;
use App\Models\User;
use App\Http\Requests\StoreMovimientoSalidaRequest;
use App\Services\GuardarMovimientoSalidaService;
use App\Services\TicketNumberService;
use Illuminate\Support\Facades\DB;
use Exception;

class SalidasController extends Controller
{
    protected GuardarMovimientoSalidaService $guardarService;

    public function __construct(GuardarMovimientoSalidaService $guardarService)
    {
        $this->middleware('auth');
        $this->guardarService = $guardarService;
    }

    /**
     * Mostrar formulario de registro de salida
     */
    public function show()
    {
        $chassis = Chassis::orderBy('chass_numero')->pluck('chass_numero');
        $users = User::role('condicionista')->orderBy('name')->pluck('name', 'id');
        return view('operaciones.salidas.salidascreate', compact('chassis', 'users'));
    }

    /**
     * Validar que el CHASSIS existe y está disponible
     */
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
            'placa'  => $chassis->chass_placa,
            'id'     => $chassis->chass_id
        ]);
    }

    /**
     * Validar que el GENSET existe y está disponible
     */
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
            'status' => 'valido',
            'id'     => $genset->gen_id
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Guardar un nuevo movimiento de salida
     * 
     * @param StoreMovimientoSalidaRequest $request Datos validados del formulario
     * @return \Illuminate\Http\RedirectResponse Redirección con mensaje de éxito o error
     */
    public function store(StoreMovimientoSalidaRequest $request)
    {
        try {
            // Validar que el usuario tiene recinto asignado
            if (!auth()->user()->recinto) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['recinto' => 'El usuario no tiene recinto asignado']);
            }

            // Guardar movimiento usando el servicio
            $resultado = $this->guardarService->guardar($request->validated());

            // Redirección con mensaje de éxito
            return redirect()->route('salidas')
                ->with('mensaje', 'Salida creada con éxito, número de boleta: ' . $resultado['boleta']);

        } catch (Exception $e) {
            // Redirección con mensaje de error
            return redirect()->back()
                ->withInput()
                ->with('mensaje de error', 'Error al guardar la salida: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show_resource(string $id)
    {
        //
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
