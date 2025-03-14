<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cliente = $_POST['cliente'];
    $nif = $_POST['nif'];
    $fecha = $_POST['fecha'];
    $concepto = $_POST['concepto'];
    $importe = $_POST['importe'];
    $iva = $_POST['iva'];

    $url = 'http://localhost:3000/generar_factura';

    $data = array(
        'cliente' => $cliente,
        'nif' => $nif,
        'fecha' => $fecha,
        'concepto' => $concepto,
        'importe' => $importe,
        'iva' => $iva
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
    $response = curl_exec($ch);
    curl_close($ch);
    $responseData = json_decode($response, true);

    $mensaje = isset($responseData['factura_id']) ? 
        "✅ Factura registrada correctamente (ID: " . $responseData['factura_id'] . ")" : 
        "❌ Error al registrar la factura.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Factura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">➕ Agregar Factura</h1>
        <?php if (isset($mensaje)) echo "<div class='alert alert-info'>$mensaje</div>"; ?>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label class="form-label">Cliente:</label>
                <input type="text" name="cliente" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">NIF:</label>
                <input type="text" name="nif" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha:</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Concepto:</label>
                <input type="text" name="concepto" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Importe (€):</label>
                <input type="number" name="importe" class="form-control" required step="0.01">
            </div>
            <div class="mb-3">
                <label class="form-label">IVA (%):</label>
                <input type="number" name="iva" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Registrar Factura</button>
        </form>
        <a href="index.php" class="btn btn-secondary mt-3">🔙 Volver al Dashboard</a>
    </div>
</body>
</html>
