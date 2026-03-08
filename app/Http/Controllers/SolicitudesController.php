<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Solicitudes;
use App\Models\Detalle_Solicitud;
use App\Models\Restaurantes;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SolicitudesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

 public function show()
{
    $solicitudes = Solicitudes::orderBy('soli_id', 'desc')->get();
    $detalles = Detalle_Solicitud::orderBy('det_id')->get(); 
    return view('solicitudes.solicitudesview', compact('solicitudes', 'detalles'));
}


public function create()
{
    $usuario = auth()->user();
    $departamentoId = $usuario->departamento;

    $restaurantes = Restaurantes::all();
    $empleados = User::where('departamento', $departamentoId)->get();

    return view('solicitudes.solicitudescreate', compact('restaurantes', 'empleados'));
}

public function store(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'soli_restaurante'   => 'required|exists:restaurantes,rest_id',
        'soli_justificación' => 'required|string|max:255',
        'soli_tiempo'        => 'required|string',
        'soli_departamento'  => 'required|exists:departamentos,dep_id',
        'empleados'          => 'required|array|min:1',
        'empleados.*'        => 'exists:users,id',
    ], [
        'soli_restaurante.required'   => 'Debe seleccionar un restaurante.',
        'soli_restaurante.exists'     => 'El restaurante seleccionado no existe.',
        'soli_justificación.required' => 'La justificación es obligatoria.',
        'soli_tiempo.required'        => 'Debe seleccionar un tiempo de comida.',
        'soli_departamento.required'  => 'Debe seleccionar un departamento.',
        'soli_departamento.exists'    => 'El departamento seleccionado no existe.',
        'empleados.required'          => 'Debe seleccionar al menos un empleado.',
        'empleados.*.exists'          => 'Uno o más empleados seleccionados no son válidos.',
    ]);

    try {
        // Calcular fecha, semana y año
        $fechaGeneracion = now();
        $semana = $fechaGeneracion->isoWeek();
        $anio   = $fechaGeneracion->year;

        // Generar número de boleta
        $contador = DB::table('solicitudes')
            ->where('soli_anio', $anio)
            ->where('soli_semana', $semana)
            ->count() + 1;

        $boleta = str_pad($contador, 6, '0', STR_PAD_LEFT);
        $codigoBoleta = "{$semana}-{$anio}-{$boleta}";

        // Crear la solicitud
        $solicitud = Solicitudes::create([
            'soli_restaurante'   => $request->soli_restaurante,
            'soli_justificación' => $request->soli_justificación,
            'soli_tiempo'        => $request->soli_tiempo,
            'soli_departamento'  => $request->soli_departamento,
            'soli_usuario'       => auth()->id(),
            'soli_generacion'    => $fechaGeneracion,
            'soli_semana'        => $semana,
            'soli_anio'          => $anio,
            'soli_boleta'        => $codigoBoleta,
            'soli_estado'        => 'generado',
        ]);

        // Guardar detalle de empleados
        foreach ($request->empleados as $empleadoId) {
            DB::table('detalle_solicitud')->insert([
                'det_solicitud' => $solicitud->soli_id,
                'det_empleado'  => $empleadoId,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        return redirect()->route('solicitudes')->with('mensaje', 'Vale generado con éxito');
    } catch (\Exception $e) {
        return redirect()->route('solicitudes.create')->with('mensaje de error', 'Hubo un problema al generar el vale. Por favor, intente nuevamente.');
    }
}

public function detalle($id)
{
    $solicitud = Solicitudes::with(['restaurante', 'departamento', 'usuario'])->findOrFail($id);
    $detalles = Detalle_Solicitud::where('det_solicitud', $id)->get();
    return view('solicitudes.solicitudesdetalle', compact('solicitud', 'detalles'));
}

public function destroy($id)
{
    try {
        // Busca el producto por su ID
        $solicitud = Solicitudes::find($id);

        // Verifica si el producto existe
        if (!$solicitud) {
            return redirect()->route('solicitudes')->withErrors(['error' => 'La Solicitud no existe.']);
        }

        // Elimina el producto
        $solicitud->delete();

        // Redirige con un mensaje de éxito
        return redirect()->route('solicitudes')->with(["mensaje" => "Solicitud eliminada con éxito"]);
    } catch (\Illuminate\Database\QueryException $e) {
        // Maneja posibles errores de base de datos
        return redirect()->route('solicitudes')->withErrors(['catch' => $e->getMessage()]);
    }
}


}
