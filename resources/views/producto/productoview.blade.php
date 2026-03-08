@extends('layouts.app')

@section('content')

<style>
    /* Fila de filtros tipo Excel */
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


    <title>Solicitudes</title>

    {{-- CSS --}}
    <head>
        <link rel="stylesheet" href="{{ asset('archivos/tables/table.css') }}">
        <link rel="stylesheet" href="{{ asset('archivos/tables/alerts.css') }}">
    </head>

    {{-- MENSAJES --}}
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

    <div class="container-fluid">
        <div class="card card-outline card-success">

            {{-- HEADER --}}
            <div class="card-header">

                <div class="d-flex align-items-center w-100">
                    <h3 class="card-title mb-0">Inventario de Genset</h3>

                </div>

                <br>
            </div>

            {{-- BODY --}}
            <div class="card-body">

                <div class="table-responsive">

                    {{-- ESTILOS DE TABLA --}}
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

                    {{-- TABLA --}}
                    <table class="table table-striped tabla-ajustada" cellspacing="0">
                        <thead class="table-dark">
                            <tr>
                <th>Genset</th>
                <th>Combustible</th>
                <th>Alternador</th>
                <th>Estado</th>
                
            </tr>
                            </tr>
                        </thead>

                         <tbody>

                         <tr class="filtros">
    <th><input type="text" class="form-control form-control-sm filtro"></th>
    <th><input type="text" class="form-control form-control-sm filtro"></th>
    <th><input type="text" class="form-control form-control-sm filtro"></th>
    <th><input type="text" class="form-control form-control-sm filtro"></th>

</tr>
                    {{-- FILA DE EJEMPLO --}}
                    <tr>
                        <td>5032</td>
                        <td>Diesel</td>
                        <td>1</td>
                        <td>Disponible</td>
                       
                    </tr>

                    <tr>
                        <td>5267</td>
                        <td>Diesel</td>
                        <td>0.7</td>
                        <td>Taller</td>
                        
                        
                    </tr>
                </tbody>
                    </table>

                    {{-- PAGINACIÓN --}}
                    

                </div>
            </div>
<div class="d-flex justify-content-center mt-4">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Anterior</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
            {{-- JS --}}
            <script src="{{ asset('archivos/tables/table.js') }}"></script>

            <script>
document.addEventListener('DOMContentLoaded', function () {
    const filtros = document.querySelectorAll('.filtro');
    const filas = document.querySelectorAll('tbody tr:not(.filtros)');

    filtros.forEach((input, index) => {
        input.addEventListener('keyup', () => {
            const valor = input.value.toLowerCase();

            filas.forEach(fila => {
                const celda = fila.children[index];
                const texto = celda.textContent.toLowerCase();

                if (texto.includes(valor)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    });
});
</script>

        </div>
    </div>

@endsection
