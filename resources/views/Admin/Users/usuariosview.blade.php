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

<title>Usuarios</title>

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
                <h3 class="card-title mb-0">Listado de Usuarios</h3>

                <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> &nbsp REGISTRAR USUARIO
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

                    {{-- HEADER --}}
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Departamento</th>
                            <th>Recinto</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>

                    <tbody>

                    {{-- FILTROS --}}
                    <form method="GET" action="{{ route('usuarios.index') }}">
                        <tr class="filtros">
                            <th><input name="id" class="form-control filtro" value="{{ request('id') }}"></th>
                            <th><input name="name" class="form-control filtro" value="{{ request('name') }}"></th>
                            <th><input name="email" class="form-control filtro" value="{{ request('email') }}"></th>
                            <th><input name="rol" class="form-control filtro" value="{{ request('rol') }}"></th>
                            <th><input name="departamento" class="form-control filtro" value="{{ request('departamento') }}"></th>
                            <th><input name="recinto" class="form-control filtro" value="{{ request('recinto') }}"></th>
                            <th>
                                <button type="submit" style="display:none;"></button>
                            </th>
                        </tr>
                    </form>

                    {{-- DATOS --}}
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>

                            <td>
                                @if($usuario->roles->isEmpty())
                                    No asignado
                                @else
                                    @foreach($usuario->roles as $role)
                                        {{ $role->name }}
                                    @endforeach
                                @endif
                            </td>

                            <td>{{ $usuario->Nombre_Departamento->dep_nombre ?? '—' }}</td>
                            <td>{{ $usuario->Nombre_Recinto->reci_nombre ?? '—' }}</td>

                            <td style="display: flex; align-items: center;">
                                <a href="{{ route('usuarios.destroy', ['id' => $usuario->id]) }}"
                                   onclick="return confirm('¿Estás seguro de eliminar este usuario?');"
                                   data-toggle="tooltip"
                                   title="Eliminar"
                                   style="margin: 0 8px;">
                                    <i class="far fa-trash-alt text-danger"></i>
                                </a>

                                <a href="{{ route('usuarios.edit', ['usuario' => $usuario->id]) }}"
                                   data-toggle="tooltip"
                                   title="Editar"
                                   style="margin: 0 8px;">
                                    <i class="far fa-edit text-primary"></i>
                                </a>

                                <a href="{{ route('usuarios.show', ['usuario' => $usuario->id]) }}"
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
                    {{ $usuarios->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>

        {{-- JS --}}
        <script src="{{ asset('archivos/tables/table.js') }}"></script>

    </div>
</div>

@endsection
