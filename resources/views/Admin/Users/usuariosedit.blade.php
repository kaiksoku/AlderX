@extends('layouts.app')

@section('content')
<head>
<style>
    .container-fluid {
        max-width: 96%;
        margin-left: auto;
        margin-right: auto;
    }

    .card {
        border-radius: 4px;
        box-shadow: 0 0 0 1px #ccc;
    }

    .card-header {
        padding: 6px;
        background: #e9ecef;
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

    .form-control,
    .form-select {
        height: 24px !important;
        padding: 0 6px !important;
        font-size: 12px !important;
        line-height: 1.2 !important;
        border-radius: 3px !important;
    }

    .card-footer .btn {
        font-size: 14px;
        padding: 6px 24px;
        border-radius: 4px;
    }

    .row > [class*="col-"] {
        margin-bottom: 3px;
    }

    .custom-legend {
        font-size: 11px;
        font-weight: 700;
        color: #1f7734ff;
    }

    .custom-fieldset {
        border: 1px solid #bbb;
        border-radius: 4px;
        padding: 8px;
    }
</style>

<title>
    Edición de Usuario
</title>

<link rel="stylesheet" href="{{ asset('archivos/fieldset.css') }}">
</head>

<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0">Editar Usuario</h4>
            <div class="card-tools">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-primary">
                    Volver al Listado <i class="fas fa-arrow-circle-left ms-1"></i>
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

                <div class="card-footer text-center" style="background: transparent; border: none; padding-bottom: 0; padding-top: 20px;">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
