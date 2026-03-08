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
  <select class="form-select" id="restaurant" required onchange="updateOrderSummary()">
    <option value="" disabled selected>Selecciona un restaurante</option>
    <option>Safari</option>
    <option>Mar y Tierra</option>
    <option>Mr. Wok</option>
  </select>
</div>

<!-- Justificación del Pedido -->
<div class="mb-3">
  <label for="justification" class="form-label">Justificación del Pedido</label>
  <input type="text" class="form-control" id="justification" placeholder="Escribe la razón del pedido" required>
</div>

<div class="row mb-3">
  <!-- Departamento -->
  <div class="col-md-6">
    <label for="department" class="form-label">Departamento</label>
    <select class="form-select" id="department" required onchange="filterEmployees(); updateOrderSummary()">
      <option value="" disabled selected>Selecciona un departamento</option>
      <option value="Interchange">Interchange</option>
      <option value="Operaciones">Operaciones</option>
      <option value="Lavado">Lavado</option>
    </select>
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
    <option data-department="Interchange" value="1">Bryan Moreno</option>
    <option data-department="Interchange" value="2">Melkin Gonzales</option>
    <option data-department="Interchange" value="3">Wilmer Hernandez</option>
    <option data-department="Operaciones" value="4">Roberto Hurtado</option>
    <option data-department="Operaciones" value="5">Jose Ajanel</option>
    <option data-department="Operaciones" value="6">Alfredo Bidal</option>
    <option data-department="Lavado" value="7">Carlos Guerra</option>
    <option data-department="Lavado" value="8">Julio Juarez</option>
    <option data-department="Lavado" value="9">Izai Cerna</option>
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
