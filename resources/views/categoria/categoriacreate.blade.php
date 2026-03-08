@extends('layouts.app')

@section('content')
<style>
.container {
    width: 800px;
    margin-left: 100px;
}
</style>
<div class="container">
    <div class="card card-outline card-success">
        <div class="card-header">
            <h3 class="card-title">Registrar una Nueva Categoría<small></small></h3>
            <div class="card-tools">
                <a href="#" class="btn btn-block btn-info btn-sm">
                    Volver al Listado<i class="fas fa-arrow-circle-left pl-1"></i>
                </a>
            </div>
        </div>

        <form action="{{route('categoria.guardar')}}" class="form-horizontal" method="POST" id="form-general" autocomplete="off">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label for="cat_nombre" class="col-sm-12 col-lg-2 control-label text-sm-left text-lg-right">Nombre de Categoría</label>
                    <div class="col-sm-12 col-lg-10">
                        <input name="cat_nombre" type="text" class="form-control" id="cat_nombre" maxlength="25" required>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-4"></div>
                    <div class="col-lg-4 text-center">
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('archivos/tables/table.js') }}"></script>
</div>
@endsection
