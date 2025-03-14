<?php
// URL del backend en Node.js
$url = 'http://localhost:3000/listar_facturas';

// Hacer la solicitud GET al backend
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Decodificar JSON
$facturas = json_decode($response, true);

// Estadísticas
$totalFacturas = count($facturas);
$totalIngresos = array_sum(array_column($facturas, 'total'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Facturación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">📊 Dashboard de Facturación</h1>
        <div class="row text-center mt-4">
            <div class="col-md-6">
                <div class="card text-bg-primary">
                    <div class="card-body">
                        <h3>Total de Facturas</h3>
                        <p class="fs-4"><?php echo $totalFacturas; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-bg-success">
                    <div class="card-body">
                        <h3>Total Ingresos</h3>
                        <p class="fs-4">€<?php echo number_format($totalIngresos, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <a href="agregar.php" class="btn btn-primary mx-2">➕ Agregar Factura</a>
            <a href="facturas.php" class="btn btn-secondary mx-2">📄 Ver Facturas</a>
        </div>
    </div>
</body>
</html>

