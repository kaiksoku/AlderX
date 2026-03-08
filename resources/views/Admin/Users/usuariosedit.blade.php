@extends('layouts.app')

@section('content')
<head>
<style>
.container {
    width: 950px;
    margin-left: 100px;
}
</style> 

<title>
    Edicion de Usuario
</title>

<link rel="stylesheet" href="{{ asset('archivos/fieldset.css') }}">
</head>

<div class="container">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Editar Usuario</h3>
            <div class="card-tools">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-success">
                    Volver al Listado <i class="fas fa-arrow-circle-left ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}" class="p-3">
                @csrf
                @method('PUT') <!-- Método PUT para actualización -->

                <!-- Nombre de Usuario -->
                <div class="mb-3 row">
                    <label for="name" class="col-lg-4 col-form-label">Nombre de Usuario</label>
                    <div class="col-lg-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ $usuario->name }}" required>
                    </div>
                </div>

                <!-- Correo Electrónico -->
                <div class="mb-3 row">
                    <label for="email" class="col-lg-4 col-form-label">Correo Electrónico</label>
                    <div class="col-lg-8">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}" required>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="mb-3 row">
                    <label for="password" class="col-lg-4 col-form-label">Nueva Contraseña</label>
                    <div class="col-lg-8">
                        <input id="password" type="password" class="form-control" name="password">
                        <small class="text-muted">Deja este campo en blanco si no deseas cambiar la contraseña</small>
                    </div>
                </div>

                <!-- Confirmar Contraseña -->
                <div class="mb-3 row">
                    <label for="password-confirm" class="col-lg-4 col-form-label">Confirmar Contraseña</label>
                    <div class="col-lg-8">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" 
                            oninput="this.setCustomValidity(this.value !== document.getElementById('password').value ? 'Las contraseñas no coinciden' : '')">
                        <div class="invalid-feedback">
                            Las contraseñas no coinciden.
                        </div>
                    </div>
                </div>
<br>
                <!-- Asignaciones -->
                <fieldset class="border p-2 col-sm-12 col-lg-12 custom-fieldset">
                    <legend class="w-auto custom-legend">Asignaciones</legend>
                    <br>
                    <div class="row">
                        <!-- Rol -->
                        <div class="col-lg-6">
                            <div class="row mb-3">
                                <label for="role" class="col-lg-4 col-form-label text-end">Rol</label>
                                <div class="col-lg-8">
                                    <select id="role" class="form-control" name="role_id" required>
                                        <option value="" disabled>Selecciona un rol</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" {{ $usuario->roles->pluck('id')->contains($role->id) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Departamento -->
                        <div class="col-lg-6">
                            <div class="row mb-3">
                                <label for="departamento" class="col-lg-4 col-form-label text-end">Departamento</label>
                                <div class="col-lg-8">
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
                        </div>
                    </div>
                </fieldset>
            </div>

            <div class="card-footer">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4 text-center">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
