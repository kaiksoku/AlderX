@extends('layouts.app')

@section('content')

<style>
    .card-body {
        overflow-x: auto;
    }

    .form-container {
        width: 95%;
        margin: auto;
    }

    /* TABLAS MÁS COMPACTAS */
    table {
        font-size: 11px;
    }

    table th,
    table td {
        padding: 3px 6px !important;
        vertical-align: middle;
    }

    /* HEADER TABLA */
    thead th {
        padding: 4px 6px !important;
        font-size: 11px;
    }

    /* CHECKS PEGADOS A LA DERECHA */
    td.text-end {
        width: 60px;
        padding-right: 4px !important;
    }

    .switch {
        margin: 0;
        float: right;
    }

    /* INPUT ROL */
    .form-control {
        height: 30px;
        font-size: 12px;
    }

    /* BOTÓN */
    .btn {
        padding: 4px 12px;
        font-size: 12px;
    }

    fieldset {
        padding: 8px;
    }

    legend {
        font-size: 12px;
        padding: 0 6px;
    }
</style>


<title>Nuevo Rol</title>

<head>
    <link rel="stylesheet" href="{{ asset('archivos/tables/alerts.css') }}">
    <link rel="stylesheet" href="{{ asset('archivos/fieldset.css') }}">
    <link rel="stylesheet" href="{{ asset('archivos/checkbox/checkbox.css') }}">
</head>

@if(session('mensaje'))
    <div class="mensaje-alert">
        {{ session('mensaje') }}
    </div>
@endif

@if($errors->any())
    <div class="mensaje-alert danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="container">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Registrar una nuevo Rol<small></small></h3>
            <div class="card-tools">
                <a href="#" class="btn btn-outline-primary">
                    Volver al Listado <i class="fas fa-arrow-circle-left pl-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
        <form action="{{route('roles.guardar')}}" class="form-horizontal" method="POST" id="form-general" autocomplete="off">
            @csrf
            
            <br>
                <div class="form-group row d-flex justify-content-center align-items-center text">
                    <label for="name" class="col-sm-12 col-lg-3 control-label text-sm-left text-lg-left">Nombre del Rol</label>
                    <div class="col-sm-12 col-lg-5">
                        <input name="name" type="text" class="form-control" id="name" maxlength="25" required>
                    </div>
                </div>
            <br>
            
            <fieldset class="border p-2 col-sm-12 col-lg-12 custom-fieldset">
    <legend class="w-auto custom-legend">Asignación de Permisos</legend>
    <br>
    @php
        $modulos = [
            'Reportes',
            'Salidas',
            'Entradas',
            'Cobros',
            'Usuarios',
            'Empleados',
            'Roles',
            'Chassis',
            'Genset',
            'Cabezales',
            'Dashboard',
            'Departamentos',
        ];
    @endphp

    @foreach ($modulos as $modulo)
        <table class="table table-striped table-hover" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th>Permisos para {{ $modulo }}</th>
                    <th class="text-end">
                        <button
                            type="button"
                            class="btn btn-sm btn-light"
                            onclick="toggleModulePermissions('{{ Str::slug($modulo) }}')">
                            <i class="fas fa-check"></i>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach (['Ver', 'Crear', 'Editar', 'Eliminar'] as $accion)
                    @php
                        $nombrePermiso = $accion . ' ' . $modulo;
                        $permiso = $permisos->firstWhere('name', $nombrePermiso);
                    @endphp
                    @if ($permiso)
                        <tr>
                            <td>
                                <span id="label_{{ $permiso->id }}">{{ $permiso->name }}</span>
                            </td>
                            <td class="text-end">
                                <label class="switch">
                                    <input
                                        type="checkbox"
                                        name="permisos[]"
                                        id="permiso_{{ $permiso->id }}"
                                        value="{{ $permiso->id }}"
                                        data-permiso-modulo="{{ Str::slug($modulo) }}"
                                        onchange="toggleTextStyle('label_{{ $permiso->id }}')">
                                    <span class="slider"></span>
                                </label>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endforeach


</fieldset>


</div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 text-center">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('archivos/tables/table.js') }}"></script>
    <script src="{{ asset('archivos/checkbox/checkbox.js') }}"></script>
    <script>
        function toggleModulePermissions(module) {
            const checkboxes = document.querySelectorAll(`[data-permiso-modulo="${module}"]`);
            const selectAll = !Array.from(checkboxes).every((checkbox) => checkbox.checked);

            checkboxes.forEach((checkbox) => {
                checkbox.checked = selectAll;
                toggleTextStyle(`label_${checkbox.value}`);
            });
        }
    </script>
</div>
@endsection