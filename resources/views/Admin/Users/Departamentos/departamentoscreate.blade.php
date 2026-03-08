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
            <h3 class="card-title">Formulario de Registro de Departamento</h3>
            <div class="card-tools">
                <a href="{{ route('departamentos') }}" class="btn btn-outline-success">
                    Volver al Listado <i class="fas fa-arrow-circle-left ms-1"></i>
                </a>
            </div>

        </div>
        <div class="card-body">
            <!-- Formulario para crear un departamento -->
            <form method="POST" action="{{route('departamentos.guardar') }}" class="p-3">
                @csrf
                <div class="mb-3 row">
                    <label for="dep_nombre" class="col-lg-4 col-form-label">Nombre del Departamento</label>
                    <div class="col-lg-8">
                        <input id="dep_nombre" type="text" class="form-control" name="dep_nombre" required>
                    </div>
                </div>
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

@endsection
