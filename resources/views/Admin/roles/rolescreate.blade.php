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

    <!-- Tabla para Permisos de Dashboard -->
    
    <table class="table table-striped table-hover" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">Permisos para Dashboard</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($permisos as $permiso)
        @if (str_contains(strtolower($permiso->name), 'dashboard'))
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
                            onchange="toggleTextStyle('label_{{ $permiso->id }}')">
                        <span class="slider"></span>
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
            </tbody>
        </table>

<!-- Tabla para Permisos de Solicitudes -->
    
<table class="table table-striped table-hover" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">Permisos para Solicitudes</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($permisos as $permiso)
        @if (str_contains(strtolower($permiso->name), 'solicitudes'))
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
                            onchange="toggleTextStyle('label_{{ $permiso->id }}')">
                        <span class="slider"></span>
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
            </tbody>
        </table>

    <!-- Tabla para Permisos de Restaurantes -->
    <div class="table-responsive">
        <table class="table table-striped table-hover" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">Permisos para Restaurantes</th>
                </tr>
            </thead>
            <tbody>
    @foreach ($permisos as $permiso)
        @if (str_contains(strtolower($permiso->name), 'restaurante'))
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
                            onchange="toggleTextStyle('label_{{ $permiso->id }}')">
                        <span class="slider"></span>
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
</tbody>
        </table>
    </div>


    <!-- Tabla para Permisos de Autorizaciones -->
    
<table class="table table-striped table-hover" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">Permisos Chassis</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($permisos as $permiso)
        @if (str_contains(strtolower($permiso->name), 'chassis'))
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
                            onchange="toggleTextStyle('label_{{ $permiso->id }}')">
                        <span class="slider"></span>
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
            </tbody>
        </table>

         <!-- Tabla para Permisos de Empleados -->
    
<table class="table table-striped table-hover" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">Permisos para Empleados</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($permisos as $permiso)
        @if (str_contains(strtolower($permiso->name), 'empleado'))
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
                            onchange="toggleTextStyle('label_{{ $permiso->id }}')">
                        <span class="slider"></span>
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
            </tbody>
        </table>

 <!-- Tabla para Permisos de Departamentos -->
    
 <table class="table table-striped table-hover" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">Permisos para Departamentos</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($permisos as $permiso)
        @if (str_contains(strtolower($permiso->name), 'departamento'))
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
                            onchange="toggleTextStyle('label_{{ $permiso->id }}')">
                        <span class="slider"></span>
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
            </tbody>
        </table>

    <!-- Tabla para Permisos de Usuarios -->
    
        <table class="table table-striped table-hover" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">Permisos para Usuarios</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($permisos as $permiso)
        @if (str_contains(strtolower($permiso->name), 'usuario'))
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
                            onchange="toggleTextStyle('label_{{ $permiso->id }}')">
                        <span class="slider"></span>
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
            </tbody>
        </table>

        <!-- Tabla para Permisos de Roles -->
    
        <table class="table table-striped table-hover" cellspacing="0">
            <thead class="table-dark">
                <tr>
                    <th colspan="2">Permisos para Roles</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($permisos as $permiso)
        @if (str_contains(strtolower($permiso->name), 'roles'))
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
                            onchange="toggleTextStyle('label_{{ $permiso->id }}')">
                        <span class="slider"></span>
                    </label>
                </td>
            </tr>
        @endif
    @endforeach
            </tbody>
        </table>


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
</div>
@endsection