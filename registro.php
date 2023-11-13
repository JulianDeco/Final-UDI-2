<?php
// Conexión a la base de datos (reemplaza con tus propios valores)
$servername = "localhost";  
$username = "root";        
$password = "";        
$dbname = "registro-kayaks";   
$conn = new mysqli($servername, $username, $password, $dbname); 

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error); }
if (isset($_POST['registro'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    
    $sql = "INSERT INTO kayak_users(name, email, password) VALUES ('$name', '$email', '$password')"; 
    if ($conn->query($sql) === TRUE) {
        echo "  <script>alert('Registro exitoso')
                    window.location.href = 'login.php';
                </script>";
    } else {
        echo "Error al registrar el usuario: " . $conn->error; 
    }
}
$conn->close(); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
