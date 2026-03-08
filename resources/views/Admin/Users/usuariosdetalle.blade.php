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
    Visualización de Usuario
</title>

<link rel="stylesheet" href="{{ asset('archivos/fieldset.css') }}">
</head>

<div class="container">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Visualizar Usuario</h3>
            <div class="card-tools">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-success">
                    Volver al Listado <i class="fas fa-arrow-circle-left ms-1"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Nombre de Usuario -->
            <div class="mb-3 row">
                <label for="name" class="col-lg-4 col-form-label">Nombre de Usuario</label>
                <div class="col-lg-8">
                    <input id="name" type="text" class="form-control" value="{{ $usuario->name }}" readonly>
                </div>
            </div>

            <!-- Correo Electrónico -->
            <div class="mb-3 row">
                <label for="email" class="col-lg-4 col-form-label">Correo Electrónico</label>
                <div class="col-lg-8">
                    <input id="email" type="email" class="form-control" value="{{ $usuario->email }}" readonly>
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
                                <input type="text" class="form-control" value="{{ $usuario->roles->pluck('name')->first() }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Departamento -->
                    <div class="col-lg-6">
                        <div class="row mb-3">
                            <label for="departamento" class="col-lg-4 col-form-label text-end">Departamento</label>
                            <div class="col-lg-8">
                            <input type="text" class="form-control" value="{{ $usuario->Nombre_Departamento ? $usuario->Nombre_Departamento->dep_nombre : 'Sin asignar' }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="card-footer">
            
        </div>
    </div>
</div>
@endsection
