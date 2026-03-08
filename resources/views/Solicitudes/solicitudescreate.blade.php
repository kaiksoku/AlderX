@extends('layouts.app')

@section('content')

<style>
/* =====================================================
   FORMULARIO OPERATIVO – ESTILO SISTEMA PORTUARIO
   ===================================================== */

body {
    background-color: #f4f6f9;
}

.container-fluid {
    max-width: 96%;
}

/* Card */
.card {
    border-radius: 4px;
    box-shadow: 0 0 0 1px #ccc;
}

/* Header */
.card-header {
    padding: 6px;
    background: #e9ecef;
}

.card-header h4 {
    font-size: 14px;
    font-weight: 700;
    margin: 0;
}

/* Body */
.card-body {
    padding: 10px 40px;
}

/* Secciones */
.form-section {
    margin-bottom: 8px;
}

/* Títulos */
.form-section h6 {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 4px;
    padding-bottom: 2px;
    border-bottom: 1px solid #bbb;
    /*color: #1f4fd8;*/
    color: #1f7734ff;
}

/* Labels */
label {
    font-size: 10px;
    font-weight: 600;
    margin-bottom: 1px;
    color: #333;
}

/* Inputs ultra compactos */
.form-control,
.form-select {
    height: 17px !important;
    padding: 0 3px !important;
    font-size: 10px !important;
    line-height: 1.1 !important;
    border-radius: 2px !important;
}

/* Textarea */
textarea.form-control {
    min-height: 45px !important;
    padding: 3px !important;
}

/* Espaciado mínimo */
.row > [class*="col-"] {
    margin-bottom: 3px;
}

/* Footer */
.card-footer {
    padding: 8px;
    background: #f8f9fa;
}

.card-footer .btn {
    font-size: 12px;
    padding: 4px 18px;
    border-radius: 4px;
}
</style>

<div class="container-fluid">
<div class="card card-outline card-success">

    {{-- ================= HEADER ================= --}}
    <div class="card-header text-center">
        <h4>REGISTRO DE SALIDA DE EQUIPO | PUERTO BARRIOS</h4>
    </div>

    <form method="POST">
        @csrf

        <div class="card-body">

            {{-- ================= DATOS GENERALES ================= --}}
            <div class="form-section">
                <h6>Datos Generales</h6>
                <div class="row">
                    <div class="col-md-2">
                        <label>Recinto</label>
                        <input class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Boleta</label>
                        <input class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Fecha</label>
                        <input type="date" class="form-control" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Hora</label>
                        <input type="time" class="form-control" value="{{ now()->format('H:i') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Cabezal</label>
                        <input class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label>Piloto</label>
                        <input class="form-control">
                    </div>
                </div>
            </div>
            {{-- ================= BLOQUE PRINCIPAL ================= --}}
            <div class="row">

                {{-- ===== COLUMNA IZQUIERDA ===== --}}
                <div class="col-md-3">
                    <div class="form-section">
                        <h6>Contenedor</h6>
                        <label>Contenedor</label><input class="form-control">
                        <label>Tipo Contenedor</label><input class="form-control">
                        <label>Naviera</label><input class="form-control">
                        <label>Setpoint</label><input class="form-control">
                        <label>Damper</label><input class="form-control">
                        <label>Sello Plástico</label><input class="form-control">
                        <label>Sello Botella</label><input class="form-control">
                    </div>
<br>
                    <div class="form-section">
                        <h6>Comercial</h6>
                        <label>Cliente</label><input class="form-control">
                        <label>Destino / Procedencia</label><input class="form-control">
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                {{-- ===== COLUMNA CENTRAL ===== --}}
                <div class="col-md-3">

                    <div class="form-section">
                        <h6>Chassis</h6>
                        <label>Chassis</label><input class="form-control">
                        <label>Placa Chassis</label><input class="form-control">
                        <label>PV Chassis</label><input class="form-control">
                        <label>Fecha PV</label><input type="date" class="form-control">
                        <label>Hubodómetro</label><input class="form-control">
                    </div>
<br>
                    <div class="form-section">
                        <h6>Llantas</h6>
                        <div class="row">
                            @for ($i = 1; $i <= 8; $i++)
                                <div class="col-6">
                                    <label>L{{ $i }}</label>
                                    <input class="form-control">
                                </div>
                            @endfor
                        </div>
                    </div>

                </div>
                <div class="col-md-1">
                </div>

                {{-- ===== COLUMNA DERECHA ===== --}}
                <div class="col-md-3">

                    <div class="form-section">
                        <h6>Genset / Motor</h6>
                        <label>Genset</label><input class="form-control">
                        <label>PV Genset</label><input class="form-control">
                        <label>Fecha PV</label><input type="date" class="form-control">
                        <label>Horómetro Salida</label><input class="form-control">
                        <label>Horómetro Ingreso</label><input class="form-control">
                    </div>

                    <div class="form-section">
                        <h6>Combustible</h6>
                        <label>Galones Salida</label><input class="form-control">
                        <label>Galones Ingreso</label><input class="form-control">
                        <label>Faltante</label><input class="form-control">
                    </div>

                </div>

            </div>
            {{-- ================= OBSERVACIONES ================= --}}
            <div class="form-section">
                <h6>Observaciones</h6>
                <textarea class="form-control"></textarea>
            </div>

        </div>

        {{-- ================= FOOTER ================= --}}
        <div class="card-footer text-center">
            <button class="btn btn-success"
        style="background-color:#1f7734ff; border-color:#1f7734ff;">
    GUARDAR
</button>

            <button type="button" class="btn btn-danger ml-3">CANCELAR</button>
        </div>

    </form>

</div>
</div>

@endsection
