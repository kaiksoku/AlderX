@extends('layouts.app')

@section('content')
<title>Ventas</title>
<style>
    /* Asegurando que la tabla tenga un diseño fijo */
    .table {
        table-layout: auto; /* Cambiado a auto para que se ajuste al contenido */
        width: 100%; /* Asegura que la tabla ocupe todo el ancho disponible */
    }

    /* Estableciendo un ancho mínimo para las columnas */
    .table th, .table td {
        /* Eliminar el ancho fijo para permitir que las columnas se ajusten dinámicamente */
        overflow: hidden; /* Evita que el contenido desborde */
        text-overflow: ellipsis; /* Agrega puntos suspensivos si el texto es demasiado largo */
        white-space: nowrap; /* Evita saltos de línea */
    }

    /* Asegura que cada columna ocupe el ancho disponible de manera equitativa */
    .table th, .table td {
        flex: 1; /* Permite que las columnas crezcan para ocupar el espacio disponible */
        min-width: 100px; /* Ancho mínimo para cada columna, ajusta según sea necesario */
    }

    /* Establece un ancho mínimo para la tabla */
    .table-responsive {
        min-width: 900px; /* Ajusta este valor según tus necesidades */
    }

    .card-body {
        min-height: 300px; /* Ajusta este valor según tus necesidades */
    }
</style>

<div class="container">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Ventas realizadas</h3>
                            <div class="card-tools">
                                <a href="{{route('ventas.create')}}" class="btn btn-block btn-success btn-sm">
                                    Crear Nueva Venta<i class="fa fa-fw fa-plus-circle pl-1"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tabla-data" cellspacing="0">
                                    <thead class='thead-dark'>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Código</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Hora</th>
                                            <th scope="col">Productos</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <th scope="col">1</th>
                                            <th scope="col">8737-8343</th>
                                            <th scope="col">04/10/2024</th>
                                            <th scope="col">18:30</th>
                                            <th scope="col">9</th>
                                            <th scope="col">112.00</th>
                                            <th scope="col"><i class="fa-regular fa-trash-can"></i>&nbsp <i class="fa-regular fa-pen-to-square"></i>&nbsp <i class="fa-regular fa-eye"></i></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
