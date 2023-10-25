<?php

session_start();
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "registro-kayaks");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}

// Función para agregar un nuevo registro
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["NOMBRE"])) {
    // Obtener datos del formulario POST
    $nombre = $_POST["NOMBRE"];
    $telefono = $_POST["TELEFONO"];
    $direccion = $_POST["DIRECCION"];
    $dni = $_POST["DNI"];
    $estado = $_POST["ESTADO"];
    $mail = $_POST["EMAIL"];
    $fecha_alta = $_POST["FECHA_ALTA"];
    $fecha_baja = $_POST["FECHA_BAJA"];

    // Crear la consulta SQL para insertar un nuevo registro en la tabla "registros"
    $sql = "INSERT INTO kayak_clientes (nombre, telefono, mail,dni, fecha_alta,  fecha_baja, direccion, estado) VALUES ('$nombre', '$telefono', '$mail', '$dni', '$fecha_alta', '$fecha_baja', '$direccion', (SELECT id FROM kayak_estados WHERE descripcion = '$estado'))";
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
$sql = "SELECT kayak_clientes.id, nombre, telefono, direccion, dni, K_E.descripcion, fecha_alta, fecha_baja, mail FROM kayak_clientes
INNER JOIN kayak_estados as K_E
ON K_E.id = kayak_clientes.estado";
$resultado = $conexion->query($sql);

// Cerrar la conexión a la base de datos
$conexion->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Aplicación de Registros de Usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="index.php"><img src="statics/logo.webp" alt="" class="logo-guarderia"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio<span class="sr-only"></span></a>
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
        <form method="post" action="clientes.php" class="d-flex flex-column align-items-center">
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
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="ESTADO">ESTADO:</label>
                        <div class="input-group mb-3">
                            <select class="form-select" id="ESTADO" name="ESTADO">
                                <option selected>-</option>
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="INACTIVO">INACTIVO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="EMAIL">EMAIL:</label>
                        <input class="form-control" type="email" id="EMAIL" name="EMAIL" required>
                    </div>
                </div>
            </div>
            <div class="row w-75 d-flex justify-content-center align-items-center">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100" name="guardar">Guardar</button>
                </div>
            </div>
        </form>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="m-3 d-flex flex-column align-items-center">
            <div class="row">
                <div class="col-md-8">
                    <label for="search">BUSCAR POR DNI:</label>
                    <input class="form-control" type="search" id="search" name="search">
                </div>
                <div class="col-md-4 py-2">
                    <br>
                    <button type="submit" class="btn btn-primary btn-block" name="searchbtn">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Lista de registros -->
        <table class="table m-3">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">DNI</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Fecha alta</th>
                    <th scope="col">Fecha baja</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search"])) {

                    $conexion = new mysqli("localhost", "root", "", "registro-kayaks");
                    $search = $_POST["search"];

                    $sql = "SELECT kayak_clientes.id, nombre, telefono, direccion, dni, K_E.descripcion, fecha_alta, fecha_baja, mail FROM kayak_clientes
                    INNER JOIN kayak_estados as K_E
                    ON K_E.id = kayak_clientes.estado 
                    WHERE dni LIKE '$search%'";

                    $resultado_search = $conexion->query($sql);

                    while ($fila = $resultado_search->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila["id"] . "</td>";
                        echo "<td>" . $fila["nombre"] . "</td>";
                        echo "<td>" . $fila["direccion"] . "</td>";
                        echo "<td>" . $fila["dni"] . "</td>";
                        echo "<td>" . $fila["telefono"] . "</td>";
                        echo "<td>" . $fila["mail"] . "</td>";
                        echo "<td>" . $fila["descripcion"] . "</td>";
                        echo "<td>" . $fila["fecha_alta"] . "</td>";
                        echo "<td>" . $fila["fecha_baja"] . "</td>";
                        // Crear un formulario para eliminar un registro con un botón "Eliminar"
                        echo "<td>
                        <form method='post' action='" . $_SERVER['PHP_SELF'] . "'>
                            <input type='hidden' name='eliminar' value='" . $fila["id"] . "'>
                            <input type='submit' value='Eliminar' class='btn btn-primary w-50'>
                        </form>
                        <form method='post' action='procesar_cliente_formulario.php'>
                            <input type='hidden' name='modificarBtn' value='" . $fila["id"] . "'>
                            <button type='submit' class='btn btn-warning w-50 my-2' data-bs-toggle='modal' data-bs-target='#exampleModal'>Modificar</button>
                        </form>

                    </td>";
                        echo "</tr>";
                    }
                } else if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila["id"] . "</td>";
                        echo "<td>" . $fila["nombre"] . "</td>";
                        echo "<td>" . $fila["direccion"] . "</td>";
                        echo "<td>" . $fila["dni"] . "</td>";
                        echo "<td>" . $fila["telefono"] . "</td>";
                        echo "<td>" . $fila["mail"] . "</td>";
                        echo "<td>" . $fila["descripcion"] . "</td>";
                        echo "<td>" . $fila["fecha_alta"] . "</td>";
                        echo "<td>" . $fila["fecha_baja"] . "</td>";
                        // Crear un formulario para eliminar un registro con un botón "Eliminar"
                        echo "<td>
                        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>
                            <input type='hidden' name='eliminar' value='" . $fila["id"] . "'>
                            <input type='submit' value='Eliminar' class='btn btn-primary w-75'>
                        </form>
                        <form method='POST' action='procesar_cliente_formulario.php'>
                            <input type='hidden' name='modificarBtn' value='" . $fila["id"] . "'>
                            <button id='btnModificarJS' type='submit' class='btn btn-warning my-2' >Modificar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>