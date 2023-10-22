<?php
// Conexión a la base de datos (reemplaza con tus propios valores)
$servername = "localhost";  // Dirección del servidor de la base de datos
$username = "root";        // Nombre de usuario de la base de datos
$password = "";        // Contraseña de la base de datos
$dbname = "registro-kayaks";   // Nombre de la base de datos
$conn = new mysqli($servername, $username, $password, $dbname); // Crea una nueva conexión a la base de datos
// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error); // Si la conexión falla, muestra un mensaje de error y termina la ejecución del script
}
if (isset($_POST['registro'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña
    // Insertar el nuevo usuario en la tabla
    $sql = "INSERT INTO kayak_users(name, email, password) VALUES ('$name', '$email', '$password')"; // Query SQL para insertar un nuevo usuario
    if ($conn->query($sql) === TRUE) {
        echo "  <script>alert('Registro exitoso')
                    window.location.href = 'login.php';
                </script>";
    } else {
        echo "Error al registrar el usuario: " . $conn->error; // Si hay un error en la inserción, muestra un mensaje de error
    }
}
$conn->close(); // Cierra la conexión a la base de datos
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <!-- Incluye los archivos CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="text-center">Registro de Usuario</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="registro">Registrar</button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <p class="text-center">¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Incluye los archivos JavaScript de Bootstrap al final de tu página -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
