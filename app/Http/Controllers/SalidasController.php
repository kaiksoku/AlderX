<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chassis;
use App\Models\Genset;
use App\Models\User;
use App\Models\Movimiento;
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
        $users = User::orderBy('name')->pluck('name', 'id');
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

    /**
     * Obtener el último ingreso del chassis al recinto actual
     * Pre-llena datos en el formulario de salida
     */
    public function obtenerUltimoIngresoChassis(Request $request)
    {
        $request->validate([
            'chass_numero' => 'required|numeric'
        ]);

        // Buscar el chassis por número para obtener su ID
        $chassis = Chassis::where('chass_numero', $request->chass_numero)->first();

        if (!$chassis) {
            return response()->json([
                'status' => 'chassis_no_existe',
                'mensaje' => 'El chassis no existe en el sistema'
            ]);
        }

        $recintoActual = auth()->user()->recinto;

        // Buscar el último movimiento del chassis USANDO SU ID
        $ultimoMovimiento = DB::table('movimientos')
            ->where('mov_chassis', $chassis->chass_id)  // 🔥 Buscar por ID del chassis
            ->orderBy('mov_id', 'desc')
            ->first();

        // Si no hay movimiento, el chassis nunca ha entrado al sistema
        if (!$ultimoMovimiento) {
            return response()->json([
                'status' => 'sin_movimientos',
                'mensaje' => 'El chassis no tiene historial de movimientos'
            ]);
        }

        // Si el último movimiento NO es un ingreso, alertar
        if ($ultimoMovimiento->mov_tipomovimiento !== 'ingreso') {
            return response()->json([
                'status' => 'no_es_ingreso',
                'mensaje' => 'El chassis no ha ingresado al recinto. El último movimiento registrado no es un ingreso.'
            ]);
        }

        // Si el último ingreso no es del recinto actual, alertar
        if ($ultimoMovimiento->mov_recinto != $recintoActual) {
            return response()->json([
                'status' => 'ingreso_otro_recinto',
                'mensaje' => 'El último ingreso del chassis fue en otro recinto, no en el actual.'
            ]);
        }

        // Si llegamos aquí, tenemos un ingreso válido del mismo recinto
        // Contar cuántas llantas tiene registradas
        $llantas = [];
        $cantidadLlantas = 0;
        
        for ($i = 1; $i <= 12; $i++) {
            $quemadoField = "mov_llanta{$i}_quemado";
            $profundidadField = "mov_llanta{$i}_profundidad";
            $marcaField = "mov_llanta{$i}_marca";

            if (!empty($ultimoMovimiento->$quemadoField) || 
                !empty($ultimoMovimiento->$profundidadField) || 
                !empty($ultimoMovimiento->$marcaField)) {
                $cantidadLlantas = $i;
                $llantas[$i] = [
                    'quemado' => $ultimoMovimiento->$quemadoField ?? '',
                    'profundidad' => $ultimoMovimiento->$profundidadField ?? '',
                    'marca' => $ultimoMovimiento->$marcaField ?? ''
                ];
            }
        }

        return response()->json([
            'status' => 'valido',
            'pv_chassis' => $ultimoMovimiento->mov_pvchassis,
            'hubodometro' => $ultimoMovimiento->mov_hubodometro,
            'cantidad_llantas' => $cantidadLlantas,
            'llantas' => $llantas,
            'boleta_ingreso' => $ultimoMovimiento->mov_boleta
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
                ->with('error', 'Error al guardar la salida: ' . $e->getMessage());
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
