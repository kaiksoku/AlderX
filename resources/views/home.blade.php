@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<head>
<link rel="stylesheet" href="{{ asset('archivos/cards/cards.css') }}">
<link rel="stylesheet" href="{{ asset('archivos/tables/table.css') }}">
<link rel="stylesheet" href="{{ asset('archivos/tables/alerts.css') }}">
</head>

@if(session('mensaje'))
    <div class="mensaje-alert success">
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
    <div class="card">
        <div class="face face1-a">
            <div class="content">
                <div class="icon">
                    <i class="fa-solid fa-id-card"></i>
                    <br>
                    <br>
                    <div class="text">Empleado del Mes</div>
                </div>
            </div>
        </div>
        <div class="face face2">
            <div class="content">
                <h3><a href="" target="_blank">Card</a></h3>
                <p>El Barcelona le acaba de meter 4 al Real Madrid</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="face face1-b">
            <div class="content">
                <div class="icon">
                    <i class="fa-solid fa-boxes-packing"></i>
                </div>
            </div>
        </div>
        <div class="face face2">
            <div class="content">
                <h3><a href="" target="_blank">Card</a></h3>
                <p>El Barcelona le acaba de meter 4 al Real Madrid</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="face face1-c">
            <div class="content">
                <div class="icon">
                    <i class="fa-solid fa-boxes-packing"></i>
                </div>
            </div>
        </div>
        <div class="face face2">
            <div class="content">
                <h3><a href="" target="_blank">Card</a></h3>
                <p>El Barcelona le acaba de meter 4 al Real Madrid</p>
            </div>
        </div>
    </div>
</div>

@endsection
