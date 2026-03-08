@extends('layouts.app')

@section('content')

<style>
    .form-chassis {
        max-width: 900px;
        margin: 20px auto;
        font-size: 14px;
    }

    .form-chassis .form-label {
        font-weight: bold;
    }

    .mensaje-alert {
        margin-bottom: 20px;
    }

    .card-header h3 {
        margin: 0;
    }
</style>

<title>Registrar Chassis</title>

<head>
    <link rel="stylesheet" href="{{ asset('archivos/tables/table.css') }}">
    <link rel="stylesheet" href="{{ asset('archivos/tables/alerts.css') }}">
</head>

<div class="container">

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

</div>


    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Registrar Chassis</h3>
        </div>

        <div class="card-body">
        
            <form action="{{ route('chassis.guardar') }}" method="POST" class="form-chassis">
                @csrf

                <div class="row mb-3">
    <div class="col-md-6">
        <label for="chass_numero" class="form-label">Número de Chassis</label>
        <input
            type="number"
            class="form-control"
            name="chass_numero"
            id="chass_numero"
            value="{{ old('chass_numero') }}"
            required
        >
    </div>

    <div class="col-md-6">
        <label for="chass_placa" class="form-label">Placa</label>
        <input
            type="text"
            class="form-control"
            name="chass_placa"
            id="chass_placa"
            value="{{ old('chass_placa') }}"
            required
        >
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-4">
        <label for="chass_ejes" class="form-label">Ejes</label>
        <select
            class="form-control"
            name="chass_ejes"
            id="chass_ejes"
            required
        >
            <option value="">Seleccione una opción</option>
            <option value="2" {{ old('chass_ejes') == 2 ? 'selected' : '' }}>2</option>
            <option value="3" {{ old('chass_ejes') == 3 ? 'selected' : '' }}>3</option>
        </select>
    </div>

    <div class="col-md-4">
        <label for="chass_medida" class="form-label">Medida</label>
        <select
            class="form-control"
            name="chass_medida"
            id="chass_medida"
            required
        >
            <option value="">Seleccione una opción</option>
            <option value="20" {{ old('chass_medida') == 20 ? 'selected' : '' }}>20</option>
            <option value="40" {{ old('chass_medida') == 40 ? 'selected' : '' }}>40</option>
        </select>
    </div>

    <div class="col-md-4">
        <label for="chass_estado" class="form-label">Estado</label>
        <input
            type="text"
            class="form-control"
            name="chass_estado"
            id="chass_estado"
            value="{{ old('chass_estado', 'Disponible') }}"
            readonly
        >
    </div>
</div>

<div class="row mb-8">
    <div class="col-md-8">
        <label for="chass_estructura" class="form-label">Especificación de Estructura</label>
        <input
            type="text"
            class="form-control"
            name="chass_estructura"
            id="chass_estructura"
            value="{{ old('chass_estructura') }}"
            required
        >
    </div>
</div>

        </div>
        <div class="card-footer">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4 text-center">
                            <button type="submit" class="btn btn-primary">Registras Chassis</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>

@endsection
