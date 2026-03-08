@extends('layouts.app')

@section('content')

<head>
<link rel="stylesheet" href="{{ asset('archivos/solicitudes/solicitud.css') }}">
</head>

<div class="container mt-5">
<div class="card card-outline card-success">
    <div class="card-header text-center">
      <h4>Formulario de Solicitud de Comida</h4>
    </div>

    <div class="card-body">
      <!-- Formulario -->
      <div class="form-container">
        <!-- Restaurante -->
        <div class="mb-3">
  <label for="restaurant" class="form-label">Selecciona un Restaurante</label>
  <select class="form-select" id="restaurant" name="soli_restaurante" required onchange="updateOrderSummary()">
              <option value="" disabled selected>Selecciona un restaurante</option>
              @foreach ($restaurantes as $restaurante)
                <option value="{{ $restaurante->rest_id }}">{{ $restaurante->rest_nombre }}</option>
              @endforeach
            </select>
</div>

<!-- Justificación del Pedido -->
<div class="mb-3">
  <label for="justification" class="form-label">Justificación del Pedido</label>
  <input type="text" class="form-control" id="justification" name="soli_justificación" placeholder="Escribe la razón del pedido" required>
</div>

<div class="row mb-3">
  <!-- Departamento -->
  <div class="col-md-6">
              <label for="department" class="form-label">Departamento</label>
              <input type="text" class="form-control" value="{{ auth()->user()->Nombre_Departamento->dep_nombre }}" disabled>
              <input type="hidden" name="soli_departamento" value="{{ auth()->user()->departamento }}">
            </div>

  <!-- Tipo de Comida -->
  <div class="col-md-6">
    <label for="mealType" class="form-label">Tiempo de Comida</label>
    <select class="form-select" id="mealType" required>
      <option value="" disabled selected>Selecciona un tiempo de comida</option>
      <option value="Desayuno">Desayuno</option>
      <option value="Almuerzo">Almuerzo</option>
      <option value="Cena">Cena</option>
      <option value="Cena de Media Noche">Cena de Media Noche</option>
    </select>
  </div>
</div>


<!-- Empleado -->
<div class="mb-3">
  <label for="employee" class="form-label">Empleado</label>
  <select class="form-select" id="employee" onchange="addEmployee()">
              <option value="" disabled selected>Selecciona un empleado</option>
              @foreach ($empleados as $empleado)
                <option data-department="{{ $empleado->Nombre_Departamento->dep_nombre ?? 'N/A' }}" value="{{ $empleado->id }}">
                  {{ $empleado->name }}
                </option>
              @endforeach
            </select>
</div>


        <!-- Área de Empleados Seleccionados -->
        <div id="selected-employees" class="selected-employees"></div>
      </div>

      <!-- Nota de Compra -->
      <div class="order-summary">
        <h5>Resumen de la Orden</h5>
        <div class="summary-item">
          <span>Restaurante:</span>
          <span id="summary-restaurant">-</span>
        </div>
        <div class="summary-item">
          <span>Departamento:</span>
          <span id="summary-department">-</span>
        </div>
        <div class="summary-item">
          <span>Platos Pedidos:</span>
          <span id="summary-quantity">0</span>
        </div>
        <div class="summary-item summary-total">
          <span>Total:</span>
          <span id="summary-total">Q 0.00</span>
        </div>
      </div>
    </div>

    <div class="card-footer text-center">
    <button type="submit" class="btn btn-success">Enviar Solicitud</button>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('archivos/solicitudes/solicitud.js') }}"></script>
@endsection
