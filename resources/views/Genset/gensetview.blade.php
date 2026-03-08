@extends('layouts.app')

@section('content')

<style>
    tr.filtros th {
        padding: 1px 1px;
    }

    tr.filtros .filtro {
        height: 18px;
        padding: 0 4px;
        font-size: 10.5px;
        line-height: 1.1;
        border-radius: 3px;
    }
</style>

<title>Genset</title>

<head>
    <link rel="stylesheet" href="{{ asset('archivos/tables/table.css') }}">
    <link rel="stylesheet" href="{{ asset('archivos/tables/alerts.css') }}">
</head>

@if(session('mensaje'))
<div class="mensaje-alert success">
    {{ session('mensaje') }}
</div>
@endif

@if(session('mensaje de error'))
<div class="mensaje-alert danger">
    {{ session('mensaje de error') }}
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

<div class="container-fluid">
<div class="card card-outline card-primary">

{{-- HEADER --}}
<div class="card-header">
    <div class="d-flex align-items-center justify-content-between w-100">
        <h3 class="card-title mb-0">Inventario de Genset</h3>

        <a href="" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> &nbsp;&nbsp;REGISTRAR GENSET&nbsp;
        </a>
    </div>
</div>

{{-- BODY --}}
<div class="card-body">
<div class="table-responsive">

<style>
    .tabla-ajustada {
        font-size: 12px;
        table-layout: auto;
        white-space: nowrap;
    }

    .tabla-ajustada th,
    .tabla-ajustada td {
        padding: 4px 8px;
    }

    @media print {
        .tabla-ajustada thead {
            background-color: #f2f2f2 !important;
        }

        .tabla-ajustada th,
        .tabla-ajustada td {
            border: 1px solid #aaa !important;
            padding: 4px 8px !important;
        }

        body {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
</style>

<table class="table table-striped tabla-ajustada">
<thead class="table-dark">
<tr>
    <th>Número</th>
    <th>Medida (Pulgadas x Galón)</th>
    <th>Consumo (Galones x Hora)</th>
    <th>Estado</th>
    <th>Opciones</th>
</tr>
</thead>

<tbody>

{{-- FILTROS --}}
<form method="GET" action="{{ route('genset') }}">
<tr class="filtros">
    <th>
        <input name="gen_numero" class="form-control filtro" value="{{ request('gen_numero') }}">
    </th>

    <th>
        <input name="gen_medida" class="form-control filtro" value="{{ request('gen_medida') }}">
    </th>

    <th>
        <input name="gen_consumo" class="form-control filtro" value="{{ request('gen_consumo') }}">
    </th>

    <th>
        <input name="gen_estado" class="form-control filtro" value="{{ request('gen_estado') }}">
    </th>

    <th>
        <button type="submit" style="display:none;"></button>
    </th>
</tr>
</form>

{{-- DATOS --}}
@foreach($genset as $item)
<tr>
    <td>{{ $item->gen_numero }}</td>
    <td>{{ $item->gen_medida ?? '—' }}</td>
    <td>{{ $item->gen_consumo }}</td>
    <td>{{ $item->gen_estado }}</td>

    <td style="display:flex; align-items:center;">
        <a href=""
           title="Editar"
           style="margin:0 8px;">
            <i class="far fa-edit text-primary"></i>
        </a>

        <a href=""
           onclick="return confirm('¿Eliminar este genset?')"
           title="Eliminar"
           style="margin:0 8px;">
            <i class="far fa-trash-alt text-danger"></i>
        </a>
    </td>
</tr>
@endforeach

</tbody>
</table>

</div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $genset->links('pagination::bootstrap-4') }}
</div>

<script src="{{ asset('archivos/tables/table.js') }}"></script>

</div>
</div>

@endsection
