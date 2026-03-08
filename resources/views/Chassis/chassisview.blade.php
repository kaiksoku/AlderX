@extends('layouts.app')

@section('content')

<style>
    /* Fila de filtros tipo Excel */
    tr.filtros th {
        padding: 1px 1px;
    }

    tr.filtros .filtro {
        height: 18px;
        padding: 0 4px;
        font-size: 10.5px;
        line-height: 1.1;
        border-radius: 3px;
    }
</style>


    <title>Solicitudes</title>

    {{-- CSS --}}
    <head>
        <link rel="stylesheet" href="{{ asset('archivos/tables/table.css') }}">
        <link rel="stylesheet" href="{{ asset('archivos/tables/alerts.css') }}">
    </head>

    {{-- MENSAJE ÉXITO --}}
    @if(session('mensaje'))
        <div class="mensaje-alert success">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- MENSAJE ERROR PERSONALIZADO --}}
    @if(session('mensaje de error'))
        <div class="mensaje-alert danger">
            {{ session('mensaje de error') }}
        </div>
    @endif

    {{-- ERRORES DE VALIDACIÓN --}}
    @if($errors->any())
        <div class="mensaje-alert danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        <div class="card card-outline card-primary">

            {{-- HEADER --}}
            <div class="card-header">
    <div class="d-flex align-items-center justify-content-between w-100">
        <h3 class="card-title mb-0">Inventario de Chassis</h3>

        <a href="{{ route('chassis.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> &nbsp &nbspREGISTRAR CHASSIS  &nbsp
        </a>
    </div>
</div>


            {{-- BODY --}}
            <div class="card-body">

                <div class="table-responsive">

                    {{-- ESTILOS DE TABLA --}}
                    <style>
                        .tabla-ajustada {
                            font-size: 12px;
                            table-layout: auto;
                            white-space: nowrap;
                        }

                        .tabla-ajustada th,
                        .tabla-ajustada td {
                            padding: 4px 8px;
                        }

                        @media print {
                            .tabla-ajustada thead {
                                background-color: #f2f2f2 !important;
                            }

                            .tabla-ajustada th,
                            .tabla-ajustada td {
                                border: 1px solid #aaa !important;
                                padding: 4px 8px !important;
                            }

                            body {
                                -webkit-print-color-adjust: exact;
                                print-color-adjust: exact;
                            }
                        }
                    </style>

                    {{-- TABLA --}}
                    <table class="table table-striped tabla-ajustada" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                <th>Chassis</th>
                <th>Placa</th>
                <th>Ejes</th>
                <th>Medida</th>
                <th>Estructura</th>
                <th>Estado</th>
                <th>Opciones</th>
                
            </tr>
                            </tr>
                        </thead>

                         <tbody>

    {{-- FILTROS --}}
    <form method="GET" action="{{ route('chassis') }}">
<tr class="filtros">
    <th><input name="chass_numero" class="form-control filtro" value="{{ request('chass_numero') }}"></th>
    <th><input name="chass_placa" class="form-control filtro" value="{{ request('chass_placa') }}"></th>
    <th><input name="chass_ejes" class="form-control filtro" value="{{ request('chass_ejes') }}"></th>
    <th><input name="chass_medida" class="form-control filtro" value="{{ request('chass_medida') }}"></th>
    <th><input name="chass_estructura" class="form-control filtro" value="{{ request('chass_estructura') }}"></th>
    <th><input name="chass_estado" class="form-control filtro" value="{{ request('chass_estado') }}"></th>
    <th class="text-center align-middle">
    <button type="submit" style="display:none;"></button>

</th>

</tr>
</form>

    {{-- DATOS --}}
    @foreach($chassis as $item)
        <tr>
            <td>{{ $item->chass_numero }}</td>
            <td>{{ $item->chass_placa ?? '—' }}</td>
            <td>{{ $item->chass_ejes }}</td>
            <td>{{ $item->chass_medida }}</td>
            <td>{{ $item->chass_estructura ?: '—' }}</td>
            <td>{{ $item->chass_estado }}</td>

            <td style="display: flex; align-items: center;">
                &nbsp;&nbsp;&nbsp;

                {{-- EDITAR (SOLO VISUAL) --}}
                <a href="{{ route('chassis.edit', $item->chass_id) }}"
   data-toggle="tooltip"
   title="Editar registro"
   style="margin: 0 8px;">
    <i class="far fa-edit text-primary"></i>
</a>


                &nbsp;&nbsp;

                {{-- ELIMINAR (SOLO VISUAL) --}}
               <a href="{{ route('chassis.destroy', $item->chass_id) }}"
   data-toggle="tooltip"
   title="Eliminar registro"
   style="margin: 0 8px;"
   onclick="return confirm('¿Está seguro de eliminar este chassis?');">
    <i class="far fa-trash-alt text-danger"></i>
</a>

            </td>
        </tr>
    @endforeach

</tbody>

                    </table>

                    {{-- PAGINACIÓN --}}
                    

                </div>
            </div>
<div class="d-flex justify-content-center mt-4">
                        <nav>
                            <div class="d-flex justify-content-center mt-4">
    {{ $chassis->links('pagination::bootstrap-4') }}
</div>

                        </nav>
                    </div>
            {{-- JS --}}
            <script src="{{ asset('archivos/tables/table.js') }}"></script>

        </div>
    </div>

@endsection
