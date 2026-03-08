@extends('layouts.app')


@section('content')
<style>
.container{
    width:800px;
    margin-left: 100px;
}
</style> 
<div class="container">
            <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">Registrar un nuevo Producto<small></small></h3>
                        <div class="card-tools">
                            <a href="{{ route('producto') }}" class="btn btn-block btn-info btn-sm">
                                Volver al Listado<i class="fas fa-arrow-circle-left pl-1"></i>
                            </a>
                        </div>
                    </div>

                    <form action="{{route('producto.guardar')}}"class="form-horizontal" method="POST" id="form-general" autocomplete="off">
                    @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="numeroCuenta" class="col-sm-12 col-lg-2 control-label text-sm-left text-lg-right">Código de Barras</label>
                                <div class="col-sm-12 col-lg-10">
                                    <input name="prod_codigo" type="text" class="form-control" id="numeroCuenta" maxlength="25" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="numeroCuenta" class="col-sm-12 col-lg-2 control-label text-sm-left text-lg-right">Nombre</label>
                                <div class="col-sm-12 col-lg-10">
                                    <input name="prod_nombre" type="text" class="form-control" id="numeroCuenta" maxlength="25" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tipoCuenta" class="col-sm-12 col-lg-2 control-label text-sm-left text-lg-right requerido">Categoria</label>
                                <div class="col-sm-12 col-lg-4">
                                    <select name="prod_categoria" class="form-control select2" id="tipoCuenta" required>
                                    <option value="" disabled selected class="placeholder-option">
                                        - Seleccionar categoría -
                                        </option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{$categoria['cat_id']}}" {{ old('ctab_tipo') == $categoria['cat_id'] ? 'selected' : '' }}>
                                        {{$categoria['cat_nombre']}}
                                        </option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="contacto" class="col-sm-12 col-lg-2 control-label text-sm-left text-lg-right">Precio</label>
                                <div class="col-sm-12 col-lg-4">
                                    <input name="prod_precio" type="text" class="form-control" id="contacto">
                                </div>

                                <label for="telefono" class="col-sm-12 col-lg-2 control-label text-sm-left text-lg-right">Cantidad</label>
                                <div class="col-sm-12 col-lg-4">
                                    <input name="prod_cantidad" type="text" class="form-control" id="telefono">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="numeroCuenta" class="col-sm-12 col-lg-2 control-label text-sm-left text-lg-right">Descripcion</label>
                                <div class="col-sm-12 col-lg-10">
                                    <input name="prod_descripcion" type="text" class="form-control" id="numeroCuenta" maxlength="60" required>
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
