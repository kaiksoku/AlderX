<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dole {{ $solicitud->departamento->dep_nombre }} - {{ ucfirst($solicitud->soli_tiempo) }} {{ \Carbon\Carbon::parse($solicitud->soli_generacion)->translatedFormat('l j \d\e F \d\e Y') }}</title>

    <style>
        @page {
            size: letter landscape;
            margin: 0.5in;
        }

        body {
            width: 100%;
            height: 100%;
            margin: 0 auto;
            font-family: Arial, sans-serif;
            font-size: 14px;
            background: white;
            overflow: hidden;
            box-sizing: border-box;
            page-break-after: avoid;
        }

        .barra-container {
            position: fixed;
            top: 30px;
            right: 0;
            padding-right: 15px;
            text-align: center;
            z-index: 999;
        }


        .barra-container svg {
            display: block;
        }

        .barra-numero {
            font-size: 12px;
            margin-top: 2px;
        }

        .encabezado-empresa {
            text-align: center;
            margin-bottom: 10px;
        }

        .encabezado-empresa h1 {
            margin: 0;
            font-size: 22px;
        }

        .encabezado-empresa h2 {
            margin: 0;
            font-size: 18px;
        }

        .encabezado-empresa h3 {
            margin: 0;
            font-size: 16px;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            margin: 30px 0 20px 0;
        }

        .encabezado div {
            width: 48%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        thead {
            background-color: #f2f2f2;
        }

        th, td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
        }

        .total {
            text-align: right;
            font-weight: bold;
            page-break-inside: avoid;
        }

        .footer {
            display: flex;
            justify-content: center;
            gap: 200px;
            margin-top: 30px;
            align-items: center;
            page-break-inside: avoid;
        }

        .footer div {
            text-align: center;
        }

        .footer .linea {
            border-top: 2px solid black;
            width: 250px;
            margin: 0 auto 10px auto;
            height: 2px;
        }

        /* ---------- IMPRESIÓN ---------- */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            thead {
                background-color: #f2f2f2 !important;
            }

            th, td {
                border: 1px solid #aaa !important;
                padding: 8px !important;
            }

            .barra-container {
                position: fixed;
                top: 30px;
                right: 0;
                padding-right: 15px;
                text-align: center;
                z-index: 999;
            }

            @page {
                size: letter landscape;
                margin: 0.5in;
            }
        }
    </style>
</head>
<body>

    <!-- Código de barras arriba a la derecha -->
    <div class="barra-container">
        <svg id="codigo-barra"></svg>
        <div class="barra-numero">{{ $solicitud->soli_boleta }}</div>
    </div>
<br><br><br>
<br><br><br>
    <!-- Encabezado institucional centrado -->
    <div class="encabezado-empresa">
        <h1>Standar Fruit de Guatemala S.A.</h1>
        <h2>Terminal Puerto Barrios</h2>
        <h3>Solicitud para Alimentación de Personal.</h3>
    </div>

    <!-- Restaurante y fecha -->
    <div class="encabezado">
        <div><strong>Restaurante:</strong> {{ $solicitud->restaurante->rest_nombre }}</div>
        <div style="text-align: right;">
            <strong>Fecha:</strong> {{ \Carbon\Carbon::parse($solicitud->soli_generacion)->translatedFormat('l j \d\e F \d\e Y') }}
        </div>
    </div>

    <!-- Tabla de empleados -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Empleado</th>
                <th>Departamento</th>
                <th>Tiempo</th>
                <th>Valor (Q)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalles as $index => $detalle)
            <tr>
                <td>{{ $index + 1}}</td>
                <td>{{ $detalle->empleado->name }}</td>
                <td>{{ $solicitud->departamento->dep_nombre }}</td>
                <td>{{ ucfirst($solicitud->soli_tiempo) }}</td>
                <td>Q 25</td>
            </tr>
            @endforeach
        <tr style="background-color: #f2f2f2;">
    <td colspan="4" style="text-align: right; font-weight: bold;">Total:</td>
    <td style="font-weight: bold;">Q {{ count($detalles) * 25 }}.00</td>
</tr>
</tbody>
</table>

    <!-- Justificacion del Pedido -->
    <div class="encabezado">
        <div><strong>Justificación del Pedido: </strong> {{ $solicitud->soli_justificación }}</div>
    </div>
<br>
<br>
    <!-- Firmas -->
    <div class="footer">
        <div>
            <div>{{ $solicitud->usuario->name }}</div>
            <div class="linea"></div>
            <div>Solicitante</div>
        </div>
        <div>
            <div>Juan Pérez</div>
            <div class="linea"></div>
            <div>Autorización</div>
        </div>
    </div>

    <!-- Librería y código de barras -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    <script>
        JsBarcode("#codigo-barra", "{{ $solicitud->soli_boleta }}", {
            format: "CODE128",
            lineColor: "#000",
            width: 1.4,
            height: 28,
            displayValue: false
        });
    </script>

</body>
</html>
