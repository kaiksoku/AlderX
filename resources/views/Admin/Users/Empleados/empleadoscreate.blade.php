@extends('layouts.app')

@section('content')
<head>
<style>
.container{
    width:950px;
    margin-left: 100px;
}
</style> 

<link rel="stylesheet" href="{{ asset('archivos/fieldset.css') }}">
</head>

<div class="container">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Formulario de Registro</h3>
            <div class="card-tools">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-success">
                    Volver al Listado <i class="fas fa-arrow-circle-left ms-1"></i>
                </a>
            </div>
        </div>
<div class="card-body">
        <form method="POST" action="{{ route('empleados.guardar') }}" class="p-3">
            @csrf
            <div class="mb-3 row">
                <label for="name" class="col-lg-4 col-form-label">Nombre de Usuario</label>
                <div class="col-lg-8">
                    <input id="name" type="text" class="form-control" name="name" required>
                </div>
            </div>
    
 
<br>
        <br>

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
                        <option value="" disabled selected>Selecciona un rol</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
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
                        <option value="" disabled selected>Asignar departamento</option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->dep_id }}">{{ $departamento->dep_nombre }}</option>
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
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
            </div>
</div>
        </form>
    </div>
</div>

@endsection
