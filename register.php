<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    header("Location: dashboard.php"); // Redirect to login page if not logged in or not an admin
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nif = $_POST['nif'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];


    // Validate input
    if (empty($username) || empty($password)) {
        echo "Por favor, completa todos los campos.";
    } else {
        // Hash the password for security
       $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // Prepare data for API request
        $data = json_encode(['username' => $username, 'password' => $hashed_password, 'nif' => $nif , 'email' => $email, 'rol' => $rol]);

        // Send POST request to the Node.js API
        $ch = curl_init('http://localhost:3000/api/auth/register');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        // Decode the response
        $responseData = json_decode($response, true);

        if ($responseData['success']) {
            header("Location: auth.php"); // Redirect to login page
            exit();
        } else {
            echo "Error: " . $responseData['message'];
        }
        
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5 shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Registro de Usuario</h4>
                    </div>
                    <div class="card-body">
                        <form action="register.php" method="POST">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="username" placeholder="Introduce tu nombre de usuario" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu correo electrónico" required>
                            </div>
                            <div class="mb-3">
                                <label for="nif" class="form-label">NIF</label>
                                <input type="text" class="form-control" id="nif" name="nif" placeholder="Introduce tu NIF" required>
                            </div>
                            <div class="mb-3">
                                <label for="rol" class="form-label">Rol</label>
                                <select class="form-select" id="rol" name="rol" required>
                                    <option value="" disabled selected>Selecciona tu rol</option>
                                    <option value="admin">Administrador</option>
                                    <option value="usuario">Usuario</option>
                                    <option value="invitado">Invitado</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center text-muted">
                        Todos los campos son obligatorios.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vincular Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
