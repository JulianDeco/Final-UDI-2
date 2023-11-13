<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "registro-kayaks");


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["MODELO"])) {
    $CamposRequeridos = ['MODELO', 'TIPO', 'CLIENTE', 'FECHA_ALTA'];
    $vacio = false;

    foreach ($CamposRequeridos as $campo) {
        if (empty($_POST[$campo])) {
            $vacio = true;
            echo "Error: El campo $campo no puede estar vacío.";
            break;
        }
    }

    if (!$vacio) {
        $rutaArchivo2 = "";

        // Handle file upload
        if ($_FILES['FOTO']['error'] == UPLOAD_ERR_OK) {
            $nombreArchivo = $_FILES['FOTO']['name'];
            $archivoTemporal = $_FILES['FOTO']['tmp_name'];
            $tipoArchivo = $_FILES['FOTO']['type'];

            // Verify that it is an image
            if (strpos($tipoArchivo, 'image') !== false) {
                $directorioDestino = 'C:/xampp/htdocs/Final-UDI-2/uploads';
                $rutaArchivo = $directorioDestino . '/' . $nombreArchivo;

                $directorioDestino2 = 'uploads';
                $rutaArchivo2 = $directorioDestino2 . '/' . $nombreArchivo;

                // Move the temporary file to the desired location
                if (move_uploaded_file($archivoTemporal, $rutaArchivo)) {
                    echo "La imagen se ha guardado con éxito en $rutaArchivo.";
                } else {
                    echo "Error al guardar la imagen.";
                }
            } else {
                echo "El archivo seleccionado no es una imagen válida.";
            }
        }

        $id = $_SESSION["id"];
        $modelo = $_POST["MODELO"];
        $tipo = $_POST["TIPO"];
        $color = $_POST["COLOR"];
        $cliente = $_POST["CLIENTE"];
        $fecha_alta = $_POST["FECHA_ALTA"];
        $fecha_baja = $_POST["FECHA_BAJA"];

        $cliente_array = explode(" ", $cliente);
        $tamano = count($cliente_array);
        $indice = $tamano - 1;

        if ($fecha_baja == '') {
            $sql = "UPDATE kayak_kayaks 
                SET modelo = '$modelo', 
                    tipo = '$tipo', 
                    color = '$color', 
                    cliente = (SELECT id FROM kayak_clientes WHERE dni = '$cliente_array[$indice]'), 
                    fecha_alta = '$fecha_alta', 
                    foto = IF('$rutaArchivo2' = '', foto, '$rutaArchivo2')
                WHERE id = '$id'";
        } else {
            $sql = "UPDATE kayak_kayaks 
                SET modelo = '$modelo', 
                    tipo = '$tipo', 
                    color = '$color', 
                    cliente = (SELECT id FROM kayak_clientes WHERE dni = '$cliente_array[$indice]'), 
                    fecha_alta = '$fecha_alta', 
                    fecha_baja = '$fecha_baja', 
                    foto = IF('$rutaArchivo2' = '', foto, '$rutaArchivo2')
                WHERE id = '$id'";
        }

        if ($conexion->query($sql) === TRUE) {
            header("Location: kayaks.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["modificarBtn"])) {

    $id = $_POST["modificarBtn"];
    $_SESSION["id"] = $id;


    $sql = "SELECT id, modelo, tipo, color, cliente, fecha_alta, fecha_baja FROM kayak_kayaks WHERE id=$id";


    $resultado = $conexion->query($sql);

    if ($resultado) {

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
            $modelo = $row['modelo'];
            $tipo = $row['tipo'];
            $color = $row['color'];
            $cliente = $row['cliente'];
            $fecha_alta = $row['fecha_alta'];
            $fecha_baja = $row['fecha_baja'];
        } else {

            echo "No se encontraron resultados.";
        }
    } else {
        echo "Error en la consulta: " . $conexion->error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar kayak</title>

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

    <form method="post" action="procesar_kayak_formulario.php" class="d-flex flex-column align-items-center content" enctype="multipart/form-data">

        <div class="row w-75">
            <div class="col-md-4">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="MODELO">MODELO:</label>
                    <input class="form-control" type="text" id="MODELO" name="MODELO" value="<?= $modelo ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="TIPO">TIPO:</label>
                    <input class="form-control" type="text" id="TIPO" name="TIPO" value="<?= $tipo ?>" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="COLOR">COLOR:</label>
                    <input class="form-control" type="text" id="COLOR" name="COLOR" value="<?= $color ?>">
                </div>
            </div>
        </div>
        <div class="row w-75">
            <div class="col-md-4">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="FOTO" class="form-label">FOTO:</label>
                    <input class="form-control" type="file" id="FOTO" name="FOTO">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="FECHA_ALTA">FECHA DE ALTA:</label>
                    <input class="form-control" type="date" id="FECHA_ALTA" name="FECHA_ALTA" value="<?= $fecha_alta ?>">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="FECHA_BAJA">FECHA DE BAJA:</label>
                    <input class="form-control" type="date" id="FECHA_BAJA" name="FECHA_BAJA" value="<?= $fecha_baja ?>">
                </div>
            </div>
        </div>
        <div class="row w-75 d-flex justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="CLIENTE">CLIENTE:</label>
                    <div class="input-group mb-3">
                        <select class="form-select" id="CLIENTE" name="CLIENTE">
                            <?php
                            $sql = "SELECT nombre, dni, id FROM kayak_clientes";
                            $conexion2 = new mysqli("localhost", "root", "", "registro-kayaks");
                            $clientes = $conexion2->query($sql);
                            while ($fila = $clientes->fetch_assoc()) {
                                $selected = ($fila["id"] == $cliente) ? 'selected' : '';
                                echo "<option value='" . $fila["dni"] . "' $selected>" . $fila["nombre"] . " " . $fila["dni"]  . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="gap: 2px">
            <a href="kayaks.php"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button></a>
            <button type="submit" class="btn btn-primary" id="editar" name="editar">Guardar cambios</button>
        </div>
    </form>

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