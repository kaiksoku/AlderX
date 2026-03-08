<!-- Sidebar HTML -->
<head>
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS Bundle (incluye Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</head>


<div class="sidebar">
<a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center justify-content-center" style="height: auto; padding: 0; margin: 0; position: relative; top: -25px;">
    <img src="{{ asset('imagenes/marca.png') }}" class="img-fluid" alt="Bienvenido" style="max-width: 85%; height: auto; display: block; filter: drop-shadow(0px 6px 10px rgba(0, 0, 0, 0.4));">
</a>
_________________________________

@can('Ver Dashboard')
  <ul>
    <li><a href="#"><i class="fa-solid fa-border-all icon"></i>&nbspDashboard</a></li>
@endcan

@can('Ver Solicitudes')
    <li class="nav-item">
            <a class="nav-link {{ Request::is('solicitudes*') ? 'active' : '' }}" href="{{ route('solicitudes') }}">
            <i class="fa-regular fa-bell icon"></i></i>
                <span class="link-text">&nbspSolicitudes</span>
            </a>
    </li>
@endcan 

@can('Ver Restaurantes')
    <li class="nav-item">
            <a class="nav-link {{ Request::is('restaurantes*') ? 'active' : '' }}" href="{{ route('restaurantes') }}">
            <i class="fa-solid fa-shop icon"></i></i>
                <span class="link-text">Restaurantes</span>
            </a>
    </li>
@endcan

@can('Ver Autorizaciones')
    <li><a href="#"><i class="fa-solid fa-book icon"></i>&nbspAutorizaciones</a></li>
@endcan
    




<!-- Personal -->
@php
    $isPersonalActive = Request::is('empleados*') || Request::is('departamentos*');
@endphp

<li class="nav-item">
    <a class="nav-link {{ $isPersonalActive ? 'active' : '' }}" href="javascript:void(0);" onclick="toggleCollapse('Personal')">
        <i class="fa-solid fa-users icon"></i>
        <span class="link-text">&nbspPersonal</span>
        <i class="fa-solid fa-arrow-down-short-wide icon-right icon-down"></i>
    </a>
    <div class="collapse {{ $isPersonalActive ? 'show' : '' }}" id="Personal">
        <ul class="nav flex-column ml-3">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('empleados*') ? 'active' : '' }}" href="{{ route('empleados') }}">
                    <i class="fa-solid fa-user icon"></i>
                    <span class="link-text">&nbsp Empleados</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('departamentos*') ? 'active' : '' }}" href="{{ route('departamentos') }}">
                    <i class="fa-regular fa-building icon"></i>
                    <span class="link-text" style="font-size: 14px">&nbspDepartamentos</span>
                </a>
            </li>
        </ul>
    </div>
</li>

<!-- Administración -->

@php
    $isAdminActive = Request::is('usuarios*') || Request::is('roles*');
@endphp
<li class="nav-item">
    <a class="nav-link {{ $isAdminActive ? 'active' : '' }}" href="javascript:void(0);" onclick="toggleCollapse('Administracion')">
        <i class="fa-solid fa-sliders icon"></i>
        <span class="link-text">&nbspAdministración</span>
        <i class="fa-solid fa-arrow-down-short-wide icon-right icon-down"></i>
    </a>
    <div class="collapse {{ $isAdminActive ? 'show' : '' }}" id="Administracion">
        <ul class="nav flex-column ml-3">
            @can('Ver Usuarios')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('usuarios*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                    <i class="fa-solid fa-user-pen icon"></i>
                    <span class="link-text">&nbsp Usuarios</span>
                </a>
            </li>
            @endcan

            @can('Ver Roles')
            <li class="nav-item">
                <a class="nav-link {{ Request::is('roles*') ? 'active' : '' }}" href="{{ route('roles') }}">
                    <i class="fa-solid fa-users-gear icon"></i>
                    <span class="link-text">&nbsp Roles</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</li>


<!-- JavaScript para controlar el toggle -->
<script>
    // Función para alternar la visibilidad de los elementos colapsables
    function toggleCollapse(id) {
        var element = document.getElementById(id);
        
        // Verificamos si el elemento está visible o no
        if (element.classList.contains('show')) {
            // Si está visible, lo ocultamos
            element.classList.remove('show');
        } else {
            // Si está oculto, lo mostramos
            element.classList.add('show');
        }
    }
</script>



  </ul>
</div>