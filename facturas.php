<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: auth.php"); // Redirect to login page if not logged in
    exit();
}
$url = 'http://localhost:3000/listar_facturas';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$facturas = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Facturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
    <?php include("./menu.php"); ?>
        <h1 class="text-center bg-primary rounded p-2 m-2">📄 Listado de Facturas</h1>
        <div class="d-flex justify-content-center mt-4">
       <table class="table table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>NIF</th>
                    <th>Fecha</th>
                    <th>Concepto</th>
                    <th>Importe (€)</th>
                    <th>IVA (%)</th>
                    <th>Total (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($facturas) {foreach ($facturas as $factura): ?>
                    <tr>
                        <td><?php echo $factura['id']; ?></td>
                        <td><?php echo $factura['cliente']; ?></td>
                        <td><?php echo $factura['nif']; ?></td>
                        <td><?php echo $factura['fecha']; ?></td>
                        <td><?php echo $factura['concepto']; ?></td>
                        <td><?php echo $factura['importe']; ?></td>
                        <td><?php echo $factura['iva']; ?>%</td>
                        <td><?php echo $factura['total']; ?></td>
                    </tr>
                <?php endforeach; 
                } else { ?>
                    <tr>
                        <td colspan="8" class="text-center"><?php echo "NO HAY REGISTROS"; ?></td>
                        </tr>
                   <?php   }?>
            </tbody>
        </table>
    
        </div>        
     </div>
</body>
</html>
