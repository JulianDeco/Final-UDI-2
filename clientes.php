<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "registro-kayaks");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Función para agregar un nuevo registro
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nombre"])) {
    // Obtener datos del formulario POST
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];

    // Crear la consulta SQL para insertar un nuevo registro en la tabla "registros"
    $sql = "INSERT INTO kayak_clientes (nombre, telefono, correo) VALUES ('$nombre', '$telefono', '$correo')";

    // Ejecutar la consulta y verificar si fue exitosa
    if ($conexion->query($sql) === TRUE) {
        // Redirigir de vuelta a la página actual después de agregar un registro
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

// Función para eliminar un registro
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar"])) {
    // Obtener el ID del registro a eliminar del formulario POST
    $id = $_POST["eliminar"];
    
    // Crear la consulta SQL para eliminar un registro basado en su ID
    $sql = "DELETE FROM kayak_clientes WHERE id=$id";
    $conexion->query($sql);
    
    // Redirigir de vuelta a la página actual después de eliminar un registro
    header("Location: " . $_SERVER['PHP_SELF']);
}

// Consulta para obtener todos los registros
$sql = "SELECT id, nombre, telefono FROM kayak_clientes";
$resultado = $conexion->query($sql);

// Cerrar la conexión a la base de datos
$conexion->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aplicación de Registros de Usuarios</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#"><img src="statics/logo.webp" alt="" class="logo-guarderia"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Inicio<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <div class="nav-item dropdown active">
                    <a class="nav-link" href="kayaks.php" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clientes</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="clientes.php">Lista clientes</a>
                        <a class="dropdown-item" href="clientes.php">Agregar cliente</a>
                        <a class="dropdown-item" href="autorizaciones.php">Agregar autorizaciones</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                
            <div class="nav-item dropdown">
            <a class="nav-link" href="kayaks.php" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kayaks</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="kayaks.php">Lista kayaks</a>
                        <a class="dropdown-item" href="kayaks.php">Agregar cliente</a>
                    </div>
                </div>
            </li>
            <li class="nav-item my-2 my-lg-0">
                <a class="nav-link" href="logout.php">Cerrar sesión</a>
            </li>
            </ul>
        </div>
        </nav>
    </header>
   <main class="content m-3">
        <h1 class="text-center">Registros de Clientes</h1>

        <!-- Formulario para agregar un nuevo registro -->
        <form method="post" action="procesar_formulario.php" class="d-flex flex-column align-items-center">
            <div class="row w-75">
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="DNI">DNI:</label>
                        <input class="form-control" type="text" id="DNI" name="DNI" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="NOMBRE">NOMBRE:</label>
                        <input class="form-control" type="text" id="NOMBRE" name="NOMBRE" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="TELEFONO">TELEFONO:</label>
                        <input class="form-control" type="text" id="TELÉFONO" name="TELEFONO">
                    </div>
                </div>
            </div>
            <div class="row w-75">
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="DIRECCION">DIRECCION:</label>
                        <input class="form-control" type="text" id="DIRECCION" name="DIRECCION">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="FECHA_ALTA">FECHA DE ALTA:</label>
                        <input class="form-control" type="date" id="FECHA_ALTA" name="FECHA_ALTA">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="FECHA_BAJA">FECHA DE BAJA:</label>
                        <input class="form-control" type="date" id="FECHA_BAJA" name="FECHA_BAJA">
                    </div>
                </div>
            </div>
            <div class="row w-75">
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="ESTADO">ESTADO:</label>
                        <input class="form-control" type="number" id="ESTADO" name="ESTADO" min="0" max="1">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="EMAIL">EMAIL:</label>
                        <input class="form-control" type="email" id="EMAIL" name="EMAIL" required>
                    </div>
                </div>
            </div>
            <div class="row w-75">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block" name="guardar">Guardar</button>
                </div>
            </div>
        </form>

        <form method="post" action="procesar_formulario.php" class="m-3 d-flex flex-column align-items-center">
            <div class="row">
                <div class="col-md-8">
                    <label for="search">BUSCAR:</label>
                    <input class="form-control" type="search" id="search" name="search" required>
                </div>
                <div class="col-md-4 py-2">
                    <br>
                    <button type="submit" class="btn btn-primary btn-block" name="search">Buscar</button>
                </div>
            </div>
        </form>
        <!-- Lista de registros -->
        <table class="table m-5 d-flex flex-row justify-content-center align-items-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>

            <?php
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila["id"] . "</td>";
                    echo "<td>" . $fila["nombre"] . "</td>";
                    echo "<td>" . $fila["telefono"] . "</td>";
                    echo "<td>" . $fila["correo"] . "</td>";
                    // Crear un formulario para eliminar un registro con un botón "Eliminar"
                    echo "<td>
                        <form method='post' action='" . $_SERVER['PHP_SELF'] . "'>
                            <input type='hidden' name='eliminar' value='" . $fila["id"] . "'>
                            <input type='submit' value='Eliminar'>
                        </form>
                    </td>";
                    echo "</tr>";
                }
            } else {
                echo "<p class=text-center>No hay registros en la base de datos.</p>";
            }
            ?>
            </tbody>
        </table>
   </main>

    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item"><a href="index.php" class="nav-link px-2 text-muted">Inicio</a></li>
        <li class="nav-item"><a href="clientes.php" class="nav-link px-2 text-muted">Clientes</a></li>
        <li class="nav-item"><a href="kayaks.php" class="nav-link px-2 text-muted">Kayaks</a></li>
        </ul>
        <p class="text-center text-muted">© 2023 Buena Ventura, Inc</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
