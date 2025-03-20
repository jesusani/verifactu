<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        echo "Por favor, completa todos los campos.";
    } else {
        if (password_verify("Chuchi00", "$2y$10\$IDKlovcchxdv3HMlWy9mF.oGtQDTIL7ZDx.XOBbln5IjQc17/DGHG")) {
            echo '¡Contraseña correcta!';
        } else {
            echo 'Contraseña incorrecta.';
        }
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
       
        // Prepare data for API request
        $data = json_encode(['username' => $username, 'password' => $hashed_password]);

        // Send POST request to the Node.js API
        $ch = curl_init('http://localhost:3000/api/auth/login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);


        $response = curl_exec($ch);
        curl_close($ch);
        if(isset($response)){
            //print_r($response);
            // Decode the response
            $responseData = json_decode($response, true);

            if (isset($responseData['success'])) {
                $_SESSION['username'] = $responseData['user']; // Store username in session
                $_SESSION['token'] = $responseData['token']; // Store token in session

                $_SESSION['rol'] = $responseData['rol']; // Store role in session

                header("Location: Dashboard.php"); // Redirect to dashboard
                exit();
            } else {
                echo "Error: " . $responseData['message'];

            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Facturación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex  mb-3 bg-primary p-2 m-2 justify-content-center align-items-center">

    <form class="card text-center" method="POST" action="">
            <input class="form-control " type="text" name="username" placeholder="USUARIO"required>
            <input class="form-control" type="password" name="password" placeholder="CONTRASEÑA"required>
        <button class=" row btn btn-info p-2 m-2 text-center" type="submit">Iniciar Sesión</button>
    </form>
</div>

<div class="container mt-5">
    <h1 class="text-center">📊 Dashboard de Facturación</h1>
    <div class="row text-center mt-4">
        <div class="col-md-6">
            <div class="card text-bg-primary">
                <div class="card-body">
                    <h3>Total de Facturas</h3>
                    <p class="fs-4"> Conectate para ver la información</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-bg-success">
                <div class="card-body">
                    <h3>Total Ingresos</h3>
                    <p class="fs-4"> Conectate para ver la información</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
