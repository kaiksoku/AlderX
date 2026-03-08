<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Fuente personalizada de Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">

  <style>
    /* Estilo personalizado para la página */
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      position: relative;
      overflow: hidden;
    }

    body::before {
      content: "";
      position: fixed;
      top: -5%;
      left: -5%;
      right: -5%;
      bottom: -5%;
      background-image: url('{{ asset('imagenes/welcome.jpg') }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      filter: blur(20px);
      z-index: -2;
    }

    body::after {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: transparent;
      z-index: -1;
    }

    /* Navbar mejorada */
    .custom-navbar {
      background: linear-gradient(90deg, rgba(0, 53, 105, 0.95), rgba(0, 53, 105, 0.95)) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .custom-collapse {
      background: linear-gradient(90deg, rgba(0, 53, 105, 0.95), rgba(0, 53, 105, 0.95));
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    /* Sección de imagen y título */
    .full-width-section {
      width: 100%;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      position: relative;
      z-index: 1;
    }

    /* Estilo del título */
    .titulo {
      font-size: 3rem;
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 2rem;
      text-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
      letter-spacing: 1px;
    }

    /* Ajuste de tamaño de la imagen */
    .full-width-section img {
      max-width: 55%;
      height: auto;
      filter: drop-shadow(0 8px 20px rgba(0, 0, 0, 0.4));
      transition: transform 0.3s ease;
    }

    .full-width-section img:hover {
      transform: scale(1.05);
    }

    /* Estilo para botones mejorados */
    .btn-outline-light {
      border: none;
      font-weight: 600;
      transition: all 0.3s ease;
      border-radius: 8px;
    }

    .btn-outline-light:hover {
      background-color: #ffffff;
      color: #134164;
      box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    .custom-footer {
      background: linear-gradient(90deg, #134164, #1d6298);
    }
    
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-dark custom-navbar">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Botones -->
    <div class="ml-auto d-flex">
      <a href="{{ route('login') }}" class="btn btn-outline-light mr-2">Iniciar sesión</a>
    </div>
  </nav>

  <div class="collapse" id="navbarToggleExternalContent">
    <div class="custom-collapse p-4">
      <h5 class="text-white h4">Bienvenido al Sistema de Logística de Aldersa</h5>
      <span class="text-white">Debe iniciar sesión para comenzar.</span><br>
      <small class="text-white">Si no cuenta con un usuario comuníquese con su supervisor.</small>
    </div>
  </div>

  <!-- Main content -->
  <div class="full-width-section">
    <h1 class="titulo">Bienvenido a</h1>
    <img src="{{ asset('imagenes/Logo_AlderX.png') }}" class="img-fluid" alt="Bienvenido">
  </div>


  <!-- Scripts de Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
