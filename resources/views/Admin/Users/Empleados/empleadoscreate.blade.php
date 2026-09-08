@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('archivos/fieldset.css') }}">
    <style>
        .card-body {
            overflow-x: auto;
        }

        .form-container {
            width: 95%;
            margin: auto;
        }

        .card-title {
            font-size: 14px;
            font-weight: 700;
            margin: 0;
        }

        label {
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 2px;
            color: #333;
        }

        table {
            font-size: 11px;
        }

        table th,
        table td {
            padding: 3px 6px !important;
            vertical-align: middle;
        }

        thead th {
            padding: 4px 6px !important;
            font-size: 11px;
        }

        td.text-end {
            width: 60px;
            padding-right: 4px !important;
        }

        .switch {
            margin: 0;
            float: right;
        }

        .form-control {
            height: 24px !important;
            padding: 0 6px !important;
            font-size: 12px !important;
            line-height: 1.2 !important;
            border-radius: 3px !important;
        }
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
</head>

<div class="container">
    <div class="card card-outline card-primary">

        <div class="card-header">
            <h3 class="card-title">Formulario de Registro<small></small></h3>
            <div class="card-tools">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-primary">
                    Volver al Listado <i class="fas fa-arrow-circle-left pl-1"></i>
                </a>
            </div>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('empleados.guardar') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Nombre de Usuario</label>
                        <input id="name" type="text" class="form-control" name="name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="role">Rol</label>
                        <input id="role" type="text" class="form-control" value="{{ $roles->first()->name ?? 'Empleado' }}" readonly>
                        <input type="hidden" name="role_id" value="{{ $roles->first()->id ?? '' }}">
                    </div>
                </div>
                <br>

                <fieldset class="custom-fieldset">
                    <legend class="w-auto custom-legend">Asignaciones</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="departamento">Departamento</label>
                            <select id="departamento" class="form-control" name="departamento" required>
                                <option value="" disabled selected>Asignar departamento</option>
                                @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento->dep_id }}">{{ $departamento->dep_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="recinto">Recinto</label>
                            <select id="recinto" class="form-control" name="recinto" required>
                                <option value="" disabled selected>Seleccionar recinto</option>
                                @foreach ($recintos as $recinto)
                                    <option value="{{ $recinto->reci_id }}">{{ $recinto->reci_nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </fieldset>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
