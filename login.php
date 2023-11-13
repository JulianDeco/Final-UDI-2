<?php
session_start();

if (isset($_SESSION['user_id'])) {

    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "registro-kayaks";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];


    $sql = "SELECT id, name, password, email FROM kayak_users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            header("Location: index.php");
            exit;
        } else {
            $error_message = "Contraseña incorrecta";
        }
    } else {
        $error_message = "Usuario no encontrado";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesión</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div style="margin: 50px auto; max-width: 400px; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h3 style="text-align: center;">Iniciar Sesión</h3>
        <?php if (isset($error_message)) : ?>
            <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="email">Email:</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="password">Contraseña:</label>
                <input class="form-control" type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="login">Iniciar Sesión</button>
            <div class="card-footer">
                <p class="text-center">¿No tienes una cuenta? <a href="registro.php">Registrarse</a></p>
            </div>
        </form>
    </div>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>