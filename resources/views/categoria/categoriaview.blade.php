@extends('layouts.app')

@section('content')
<title>Categorías</title>


@if(session('mensaje'))
    <div class="alert alert-success mensaje-alert">
        {{ session('mensaje') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger mensaje-alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<head>
    <link rel="stylesheet" href="{{ asset('archivos/tables/table.css') }}">
</head>

<div class="container-fluid">
    <div class="card card-outline card-success">
        <div class="card-header">
            <div class="d-flex align-items-center w-100">
                <h3 class="card-title mb-0">Registro de Categorías</h3>
                <div class="ms-auto d-flex align-items-center">
                    <a href="{{ route('categoria.create') }}" class="btn btn-success btn-sm ml-2">
                        Registrar una Categoría<i class="fa fa-fw fa-plus-circle pl-1"></i>
                    </a>
                </div>
            </div>
            <br>
            <div class="d-flex align-items-center justify-content-between">
                <!-- Barra de búsqueda -->
                <div class="ms-auto d-flex align-items-center">
                    <div class="input-group-wrapper">
                        <form action="#" method="GET" class="input-group" id="search-form">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="search" id="form1" name="search" class="form-control" placeholder="Buscar categoría" />
                            </div>
                            <button type="submit" class="btn btn-primary" data-mdb-ripple-init>
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                @if($categorias->isEmpty())
                    <p class="text-center">No hay resultados para "{{ request('search') }}"</p>
                @else
                    <table class="table table-striped table-hover" id="tabla-data" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Categoría</th>
                                <th scope="col">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $categoria)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $categoria->cat_nombre }}</td>
                                    <td>
                                        <a href="#" onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?');">
                                            <i class="text-danger far fa-trash-alt"></i>
                                        </a>&nbsp;
                                        <a href="#">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>&nbsp;
                                        <i class="fa-regular fa-eye"></i>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Enlaces de paginación -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $categorias->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
        
        <script src="{{ asset('archivos/tables/table.js') }}"></script>
    </div>
</div>
@endsection
