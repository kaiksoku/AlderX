@extends('layouts.app')

@section('content')
<head>
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

<title>
    Edición de Usuario
</title>

<link rel="stylesheet" href="{{ asset('archivos/fieldset.css') }}">
</head>

<div class="container">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Editar Usuario<small></small></h3>
            <div class="card-tools">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-primary">
                    Volver al Listado <i class="fas fa-arrow-circle-left pl-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                @csrf
                @method('PUT') <!-- Método PUT para actualización -->

                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Nombre de Usuario</label>
                        <input id="name" type="text" class="form-control" name="name" value="{{ $usuario->name }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="email">Correo Electrónico</label>
                        <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="password">Nueva Contraseña</label>
                        <input id="password" type="password" class="form-control" name="password">
                        <small class="text-muted">Deja este campo en blanco si no deseas cambiar la contraseña</small>
                    </div>

                    <div class="col-md-6">
                        <label for="password-confirm">Confirmar Contraseña</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" 
                            oninput="this.setCustomValidity(this.value !== document.getElementById('password').value ? 'Las contraseñas no coinciden' : '')">
                        <div class="invalid-feedback">
                            Las contraseñas no coinciden.
                        </div>
                    </div>
                </div>
                <br>
                <fieldset class="custom-fieldset">
                    <legend class="w-auto custom-legend">Asignaciones</legend>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="role">Rol</label>
                            <select id="role" class="form-control" name="role_id" required>
                                <option value="" disabled>Selecciona un rol</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $usuario->roles->pluck('id')->contains($role->id) ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="departamento">Departamento</label>
                            <select id="departamento" class="form-control" name="departamento" required>
                                <option value="" disabled>Asignar departamento</option>
                                @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento->dep_id }}" {{ $usuario->departamento == $departamento->dep_id ? 'selected' : '' }}>
                                        {{ $departamento->dep_nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </fieldset>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 text-center">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
