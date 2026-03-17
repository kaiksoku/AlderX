@extends('layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('archivos/despacho/formdespacho.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    <STYLE>
        
    </STYLE>
</head>

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
                        <input
                            type="text"
                            class="form-control"
                            name="mov_recinto"
                            value="{{ auth()->user()->Nombre_Recinto->reci_nombre ?? '' }}"
                            readonly
                        >
                    </div>
                    <div class="col-md-2">
                        <label>Boleta / EIR</label>
                        <input type="number" class="form-control" name="mov_boleta" required>
                    </div>
                    <div class="col-md-2">
                        <label>Fecha</label>
                        <input type="date" class="form-control" name="mov_fecha" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label>Hora</label>
                        <input 
                        type="text" 
                        id="hora" 
                        name="mov_hora" 
                        class="form-control" 
                        placeholder="HH:mm (24h)" 
                        maxlength="5"
                        required
                    >
                    </div>
                    <div class="col-md-2">
                        <label>Cabezal</label>
                        <input class="form-control"
                                name="mov_cabezal"
                                required
                                pattern="(\d+|AGREGADO)"
                                title="Ingrese solo números o la palabra AGREGADO"
                                style="text-transform: uppercase;">
                    </div>
                    <div class="col-md-2">
                        <label>Placa Cabezal</label>
                        <input 
                            id="placa_cabezal"
                            name="mov_placa_cabezal"
                            class="form-control"
                            maxlength="8"
                            pattern="C-[0-9]{3}[A-Z]{3}"
                            placeholder="C-123ABC"
                            style="text-transform: uppercase;"
                            required
                        >

                    </div>
                </div>
            </div>
            {{-- ================= BLOQUE PRINCIPAL ================= --}}
            <div class="row">

                {{-- ===== COLUMNA IZQUIERDA ===== --}}
                <div class="col-md-3">
                    <div class="form-section">
                        <h6>Contenedor</h6>
                        <label>Contenedor</label>
                        <input id="contenedor" class="form-control"
                            name="mov_contenedor"
                            pattern="[A-Za-z]{4}[0-9]{7}"
                            title="4 letras y 7 números">


                        <div class="row">
                            <div class="col-md-6">
                                <label>Previaje</label>
                                <input id="previaje" class="form-control" name="mov_pv_contenedor">
                            </div>
                            <div class="col-md-6">
                                <label>Fecha PV</label>
                                <input id="fecha_pv" type="date" class="form-control" name="mov_pv_contenedor_fecha" value="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>

                        <label>Naviera</label>
                        <input id="naviera" class="form-control" name="mov_naviera">

                        <div class="row">
                            <div class="col-md-6">
                                <label>Setpoint</label>
                                <input id="setpoint" class="form-control" name="mov_setpoint">
                            </div>
                            <div class="col-md-6">
                                <label>Damper</label>
                                <input id="damper" class="form-control" name="mov_damper">
                            </div>
                        </div>

                        <label>Marchamo</label>
                        <input id="sello_plastico" class="form-control" name="mov_sello_contenedor">

                    </div>
                        <br>
                    <div class="form-section">
                        <h6>Comercial</h6>
                        <label>Contenido</label><input class="form-control" name="mov_contenido" required>
                        <label>Cliente</label><input class="form-control" name="mov_cliente">
                        <label>Destino / Procedencia</label><input class="form-control" name="mov_destino">
                        <label>Conductor</label><input class="form-control" name="mov_conductor" required>
                    </div>
                </div>
                <div class="col-md-1">
                </div>

                {{-- ===== COLUMNA CENTRAL ===== --}}
                <div class="col-md-4">

                    <div class="form-section">
                        <h6>Chassis</h6>
                        <label>Chassis</label><small id="chassis-feedback" style="font-size:10px;"></small>
                            <input
                                type="text"
                                id="chass_numero"
                                class="form-control"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                autocomplete="off"
                                required>
                            <input type="text" class="form-control" name="mov_chassis" id="mov_chassis_id">
                            
                        <label>Placa Chassis</label><input type="text" id="placa" name="mov_chass_placa" class="form-control" readonly>
                        <label>PV Chassis</label><input class="form-control" name="mov_pv_chassis">
                        <label>Fecha PV</label><input type="date" class="form-control" name="mov_fecha_pv_chassis" value="{{ now()->format('Y-m-d') }}">
                        <label>Hubodómetro</label><input class="form-control" type="number" name="mov_hubodometro">
                    </div>
                    <br>
                    <div class="form-section">
                        <h6>Interchange</h6>
                        <label>Condicionista</label><input class="form-control" name="mov_condicionista">
                        <label>Digitador</label><input class="form-control" name="mov_digitador" value="{{ auth()->user()->name ?? '' }}" readonly>
                        <label>Movimiento</label><input value="Salida" class="form-control" name="mov_movimiento" readonly>
                        <div class="d-flex justify-content-center mt-3">
                                    <button type="button" 
                                        class="info-adicional-btn"
                                        data-toggle="modal" 
                                        data-target="#llantasModal">
                                        Información Adicional <i class="fas fa-plus"></i>
                                    </button>

                        </div>
                    </div>
<!-- Modal Inspecciones extras -->
<div class="modal fade" id="llantasModal" tabindex="-1" role="dialog" aria-labelledby="llantasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="llantasModalLabel">Inspección de Llantas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12"><!--Llantas ocultas -->
                            <div class="form-section">
                                <h6>Llantas</h6>
                                <div class="row">
                                    <div class="col-2">
                                        <label>Llanta 1</label>
                                        <input name="mov_llanta1_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta1_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta1_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA" required>
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 2</label>
                                        <input name="mov_llanta2_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta2_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta2_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA" required>
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 3</label>
                                        <input name="mov_llanta3_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta3_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta3_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA" required>
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 4</label>
                                        <input name="mov_llanta4_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta4_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta4_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA" required>
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 5</label>
                                        <input name="mov_llanta5_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta5_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta5_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA" required>
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 6</label>
                                        <input name="mov_llanta6_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta6_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta6_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA" required>
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 7</label>
                                        <input name="mov_llanta7_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta7_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta7_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA" required>
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 8</label>
                                        <input name="mov_llanta8_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta8_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD" required>
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta8_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA" required>
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 9</label>
                                        <input name="mov_llanta9_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS">
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta9_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD">
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta9_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA">
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 10</label>
                                        <input name="mov_llanta10_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS">
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta10_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD">
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta10_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA">
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 11</label>
                                        <input name="mov_llanta11_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS">
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta11_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD">
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta11_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA">
                                    </div>
                                    <div class="col-2">
                                        <label>Llanta 12</label>
                                        <input name="mov_llanta12_1" class="form-control" type="number" min="0" max="999999" step="1" placeholder="QUEMADOS">
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta12_2" class="form-control" type="number" min="0" max="999999" step="1" placeholder="PROFUNDIDAD">
                                    </div>
                                    <div class="col-2">
                                        <label></label>
                                        <input name="mov_llanta12_3" class="form-control" type="text" style="text-transform: uppercase;" placeholder="MARCA">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

                </div>
                <div class="col-md-1">
                </div>

                {{-- ===== COLUMNA DERECHA ===== --}}
                <div class="col-md-3">

                    <div style="margin-bottom: 15px; display: flex; gap: 10px; align-items: center;">
                        <div>
                            <input type="checkbox" id="toggle_genset_2" name="toggle_genset_2">
                            <label for="toggle_genset_2" style="margin-left: 5px; display: inline;">Agregar segundo Genset/Motor</label>
                        </div>
                        <input type="checkbox" id="sin_motor" name="sin_motor">
                        <label for="sin_motor" style="margin-left: 5px; display: inline;">Despacho sin motor</label>
                    </div>

                    {{-- ===== CONTENEDOR FLEX PARA GENSETS ===== --}}
                    <div id="genset_container" style="display: flex; gap: 10px; align-items: flex-start;">
                        
                        <div class="form-section" id="genset_1_section" style="flex: 1;">
                            <h6>Genset / Motor</h6>
                            <label>Genset</label>
                            <small id="genset-feedback" style="font-size:10px;"></small>
                            <input
                                type="text"
                                id="gen_numero"                           
                                class="form-control"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                autocomplete="off">
                            <input type="text" class="form-control" name="gen_numero_1" id="gen_id_1">
                            <div class="row">
                                <div class="col-6">
                                    <label>PV Genset</label>
                                    <input class="form-control" name="gen_pv">
                                </div>
                                <div class="col-6">
                                    <label>Fecha PV</label>
                                    <input type="date" class="form-control" name="gen_fecha_pv" value="{{ now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Horómetro Salida</label>
                                    <input class="form-control" name="gen_horometro_salida">
                                </div>
                                <div class="col-6">
                                    <label>Horómetro Ingreso</label>
                                    <input class="form-control" name="gen_horometro_ingreso">
                                </div>
                            </div>
                        </div>

                        {{-- ===== SEGUNDO GENSET (OCULTO POR DEFECTO) ===== --}}
                        <div class="form-section" id="genset_2_section" style="display: none; flex: 1;">
                            <h6>Genset / Motor 2</h6>
                            <label>Genset</label>
                            <small id="genset-feedback-2" style="font-size:10px;"></small>
                            <input
                                type="text"
                                id="gen_numero_2"
                                class="form-control"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                autocomplete="off">
                            <input type="text" class="form-control" name="gen_numero_2" id="gen_id_2">    
                            <div class="row">
                                <div class="col-6">
                                    <label>PV Genset</label>
                                    <input class="form-control" name="gen_pv_2">
                                </div>
                                <div class="col-6">
                                    <label>Fecha PV</label>
                                    <input type="date" class="form-control" name="gen_fecha_pv_2" value="{{ now()->format('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Horómetro Salida</label>
                                    <input class="form-control" name="gen_horometro_salida_2">
                                </div>
                                <div class="col-6">
                                    <label>Horómetro Ingreso</label>
                                    <input class="form-control" name="gen_horometro_ingreso_2">
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ===== CONTENEDOR FLEX PARA COMBUSTIBLE ===== --}}
                    <div id="combustible_container" style="display: flex; gap: 10px; align-items: flex-start;">
                        
                        <div class="form-section" id="combustible_1_section" style="flex: 1;">
                            <h6>Combustible</h6>
                            <label>Galones Salida</label><input class="form-control" name="mov_comb_galones_salida">
                            <div class="row">
                                <div class="col-6">
                                    <label>Galones cargados</label>
                                    <input class="form-control" name="mov_comb_carga">
                                </div>
                                <div class="col-6">
                                    <label>Nivel Ingreso</label>
                                    <input class="form-control" name="mov_comb_nivel_ingreso">
                                </div>
                            </div>
                            <h6>Marchamos de tanque</h6>
                            <div class="row">
                                <div class="col-6">
                                    <label>Tanque</label><input class="form-control" name="mov_comb_tanque">
                                </div>
                                <div class="col-6">
                                    <label>Puerta</label><input class="form-control" name="mov_comb_puerta">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Panel 1</label><input class="form-control" name="mov_comb_panel_1">
                                </div>
                                <div class="col-6">
                                    <label>Panel 2</label><input class="form-control" name="mov_comb_panel_2">
                                </div>
                            </div>
                        </div>

                        {{-- ===== SEGUNDO COMBUSTIBLE (OCULTO POR DEFECTO) ===== --}}
                        <div class="form-section" id="combustible_2_section" style="display: none; flex: 1;">
                            <h6>Combustible 2</h6>
                            <label>Galones Salida</label><input class="form-control" name="mov_comb_galones_salida_2">
                            <div class="row">
                                <div class="col-6">
                                    <label>Galones cargados</label>
                                    <input class="form-control" name="mov_comb_carga_2">
                                </div>
                                <div class="col-6">
                                    <label>Nivel Ingreso</label>
                                    <input class="form-control" name="mov_comb_nivel_ingreso_2">
                                </div>
                            </div>
                            <h6>Marchamos de tanque</h6>
                            <div class="row">
                                <div class="col-6">
                                    <label>Tanque</label><input class="form-control" name="mov_comb_tanque_2">
                                </div>
                                <div class="col-6">
                                    <label>Puerta</label><input class="form-control" name="mov_comb_puerta_2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label>Panel 1</label><input class="form-control" name="mov_comb_panel_1_2">
                                </div>
                                <div class="col-6">
                                    <label>Panel 2</label><input class="form-control" name="mov_comb_panel_2_2">
                                </div>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
            {{-- ================= OBSERVACIONES ================= --}}
            <div class="form-section">
                <h6>Observaciones</h6>
                <textarea class="form-control" name="mov_observaciones"></textarea>
            </div>

        </div>

        {{-- ================= FOOTER ================= --}}
        <div class="card-footer text-center">
            <button
                id="btn-guardar"
                type="submit"
                class="btn btn-success"
                style="background-color:#1f7734ff; border-color:#1f7734ff;"
                onclick="validarHora(event)">GUARDAR
            </button>



            <button type="button" class="btn btn-danger ml-3">CANCELAR</button>
        </div>

    </form>

<script src="{{ asset('archivos/despacho/formdespacho.js') }}" defer></script>
<style>
input, textarea {
    text-transform: uppercase !important;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Forzar mayúsculas en todos los campos input y textarea
    document.querySelectorAll('input, textarea').forEach(function(input) {
        input.addEventListener('input', function() {
            // Solo aplica a campos de texto, email, search, number, password, etc.
            if (this.type !== 'password' && this.type !== 'hidden') {
                this.value = this.value.toUpperCase();
            }
        });
    });
});


                     
document.addEventListener('DOMContentLoaded', function () {
    const inputHora = document.getElementById('hora');

    inputHora.addEventListener('input', () => {
        let valor = inputHora.value.replace(/\D/g, '');

        if (valor.length >= 3) {
            valor = valor.substring(0,2) + ':' + valor.substring(2,4);
        }

        inputHora.value = valor;
    });
});

                    </script>


</div>
</div>


@endsection
