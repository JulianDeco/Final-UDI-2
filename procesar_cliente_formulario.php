<?php

session_start();

$conexion = new mysqli("localhost", "root", "", "registro-kayaks");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["DNI"])) { 
    $nombre = $_POST["NOMBRE"];
    $telefono = $_POST["TELEFONO"];
    $direccion = $_POST["DIRECCION"];
    $dni = $_POST["DNI"];
    $estado = $_POST["ESTADO"];
    $mail = $_POST["EMAIL"];
    $fecha_alta = $_POST["FECHA_ALTA"];
    $fecha_baja = $_POST["FECHA_BAJA"];
    $id = $_SESSION['id'];


    $sql = "UPDATE kayak_clientes 
        SET nombre = '$nombre', 
            telefono = '$telefono', 
            mail = '$mail', 
            dni = '$dni', 
            fecha_alta = '$fecha_alta', 
            fecha_baja = '$fecha_baja', 
            direccion = '$direccion', 
            estado = '$estado'
        WHERE id = '$id'";



    if ($conexion->query($sql) === TRUE) {

        header("Location: clientes.php" );
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar cliente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="index.php"><img src="statics/kayaking.png" alt="" class="logo-guarderia"></a>
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
                            </div>
                        </div>
                    </li>
                    <li class="nav-item">

                        <div class="nav-item dropdown">
                            <a class="nav-link" href="kayaks.php" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Kayaks</a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="kayaks.php">Lista kayaks</a>
                                <a class="dropdown-item" href="kayaks.php">Agregar kayak</a>
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


<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["modificarBtn"])) {
    
    $id = $_POST["modificarBtn"];
    $_SESSION["id"] = $id;


    $sql = "SELECT id, nombre, telefono, direccion, dni, (SELECT descripcion FROM kayak_estados WHERE id = $id), fecha_alta, fecha_baja, mail FROM kayak_clientes WHERE id=$id";
    if ($conexion->query($sql) === TRUE) {

    } else {
    echo "Error en la consulta: " . $conexion->error;
    }
                        
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $dni = $row['dni'];
        $nombre = $row['nombre'];
        $telefono = $row['telefono'];
        $direccion = $row['direccion'];
        $fecha_alta = $row['fecha_alta'];
        $fecha_baja = $row['fecha_baja'];
        $estado = $row['estado'];
        $mail = $row['mail'];
    } else {

        echo "No se encontraron resultados.";

    }

?>

<form method="post" action="procesar_cliente_formulario.php" class="d-flex flex-column align-items-center content">
    <div class="row w-75">
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="DNI">DNI:</label>
                <input class="form-control" type="text" id="DNI" name="DNI" value="<?= $dni ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="NOMBRE">NOMBRE:</label>
                <input class="form-control" type="text" id="NOMBRE" name="NOMBRE" value="<?= $nombre ?>" required>
            </div>
        </div>
    </div>
    <div class="row w-75">
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="TELEFONO">TELEFONO:</label>
                <input class="form-control" type="text" id="TELEFONO" name="TELEFONO" value="<?= $telefono ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="DIRECCION">DIRECCION:</label>
                <input class="form-control" type="text" id="DIRECCION" name="DIRECCION" value="<?= $direccion ?>">
            </div>
        </div>
    </div>
    <div class="row w-75">
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="FECHA_ALTA">FECHA DE ALTA:</label>
                <input class="form-control" type="date" id="FECHA_ALTA" type=date (yyyy-mm-dd) name="FECHA_ALTA" value="<?= $fecha_alta ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="FECHA_BAJA">FECHA DE BAJA:</label>
                <input class="form-control" type="date" id="FECHA_BAJA" type=date (yyyy-mm-dd) name="FECHA_BAJA" value="<?= $fecha_baja ?>">
            </div>
        </div>
    </div>
    <div class="row w-75">
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="ESTADO">ESTADO:</label>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="ESTADO">Estados</label>
                    <select class="form-select" id="ESTADO" name="ESTADO">
                        <option value="1" <?= ($estado == 'ACTIVO') ? 'selected' : '' ?>>ACTIVO</option>
                        <option value="2" <?= ($estado == 'INACTIVO') ? 'selected' : '' ?>>INACTIVO</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="EMAIL">EMAIL:</label>
                <input class="form-control" type="email" id="EMAIL" name="EMAIL" value="<?= $mail ?>" required>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="gap: 2px">
        <a href="clientes.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button></a>
        <button type="submit" class="btn btn-primary" id="editar" name="editar">Guardar cambios</button>
    </div>
</form>

<?php
}
?>

    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="index.php" class="nav-link px-2 text-muted">Inicio</a></li>
            <li class="nav-item"><a href="clientes.php" class="nav-link px-2 text-muted">Clientes</a></li>
            <li class="nav-item"><a href="kayaks.php" class="nav-link px-2 text-muted">Kayaks</a></li>
        </ul>
        <p class="text-center text-muted">© 2023 Guardería Náutica, Inc</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>
</html>