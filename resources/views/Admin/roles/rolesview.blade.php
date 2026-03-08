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

<title>Roles</title>

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
    <div class="card card-outline card-success">

        {{-- HEADER --}}
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between w-100">
                <h3 class="card-title mb-0">Listado de Roles</h3>

                <a href="{{ route('roles.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> &nbsp REGISTRAR ROL
                </a>
            </div>
        </div>

        {{-- BODY --}}
        <div class="card-body">

            <div class="table-responsive">

                {{-- ESTILOS TABLA --}}
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
                </style>

                {{-- TABLA --}}
                <table class="table table-striped tabla-ajustada" cellspacing="0">

                    {{-- HEADER --}}
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Rol</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>

                    <tbody>

                    {{-- FILTROS --}}
                    <form method="GET" action="{{ route('roles') }}">
                        <tr class="filtros">
                            <th>
                                <input name="id" class="form-control filtro" value="{{ request('id') }}">
                            </th>
                            <th>
                                <input name="name" class="form-control filtro" value="{{ request('name') }}">
                            </th>
                            <th>
                                <button type="submit" style="display:none;"></button>
                            </th>
                        </tr>
                    </form>

                    {{-- DATOS --}}
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>

                            <td style="display: flex; align-items: center;">
                                <a href="{{ route('roles.eliminar', ['id' => $role->id]) }}"
                                   onclick="return confirm('¿Estás seguro de eliminar este rol?');"
                                   data-toggle="tooltip"
                                   title="Eliminar"
                                   style="margin: 0 8px;">
                                    <i class="far fa-trash-alt text-danger"></i>
                                </a>

                                <a href="#"
                                   data-toggle="tooltip"
                                   title="Editar"
                                   style="margin: 0 8px;">
                                    <i class="far fa-edit text-primary"></i>
                                </a>

                                <a href="#"
                                   data-toggle="tooltip"
                                   title="Ver detalles"
                                   style="margin: 0 8px;">
                                    <i class="far fa-eye text-dark"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                {{-- PAGINACIÓN --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $roles->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>

        {{-- JS --}}
        <script src="{{ asset('archivos/tables/table.js') }}"></script>

    </div>
</div>

@endsection
