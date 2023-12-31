<?php

session_start();

$conexion = new mysqli("localhost", "root", "", "registro-kayaks");

if ($conexion->connect_error) {
    die("Error en la conexión a la base de datos: " . $conexion->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["MODELO"])) {
    $nombreArchivo = $_FILES['FOTO']['name'];
    $archivoTemporal = $_FILES['FOTO']['tmp_name'];
    $tipoArchivo = $_FILES['FOTO']['type'];

    
    if (strpos($tipoArchivo, 'image') !== false) {
        
        $directorioDestino = 'C:/xampp/htdocs/Final-UDI-2/uploads';
        $rutaArchivo = $directorioDestino . '/' . $nombreArchivo;

        $directorioDestino2 = 'uploads';
        $rutaArchivo2 = $directorioDestino2 . '/' . $nombreArchivo;

        if (move_uploaded_file($archivoTemporal, $rutaArchivo)) {
            echo "La imagen se ha guardado con éxito en $rutaArchivo.";
            
            $modelo = $_POST["MODELO"];
            $tipo = $_POST["TIPO"];
            $color = $_POST["COLOR"];
            $cliente = $_POST["CLIENTE"];
            $cliente_array = explode(" ", $cliente);
            $fecha_alta = $_POST["FECHA_ALTA"];
            $fecha_baja = $_POST["FECHA_BAJA"];

            $tamano = count($cliente_array);
            $indice = $tamano - 1;

            
            $sql = "INSERT INTO kayak_kayaks (modelo, tipo, color, cliente, foto, fecha_alta, fecha_baja) VALUES ('$modelo', '$tipo', '$color', (SELECT id FROM kayak_clientes WHERE dni = '$cliente_array[$indice]'), '$rutaArchivo2', '$fecha_alta', '$fecha_baja')";
            
            if ($conexion->query($sql) === TRUE) {
                
                header("Location: " . $_SERVER['PHP_SELF']);
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        } else {
            echo "Error al guardar la imagen.";
        }
    } else {
        echo "El archivo seleccionado no es una imagen válida.";
    }
    
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["eliminar"])) {
    
    $id = $_POST["eliminar"];

    
    $sql = "DELETE FROM kayak_kayaks WHERE id=$id";
    $conexion->query($sql);

   
    header("Location: " . $_SERVER['PHP_SELF']);
}




$sql ="SELECT kayak_kayaks.id, modelo, tipo, color, kayak_clientes.nombre as cliente, kayak_kayaks.fecha_alta, kayak_kayaks.fecha_baja, foto FROM kayak_kayaks
        INNER JOIN kayak_clientes
        ON kayak_kayaks.cliente = kayak_clientes.id";
$resultado = $conexion->query($sql);


$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            <li class="nav-item">
                <div class="nav-item dropdown">
                    <a class="nav-link" href="kayaks.php" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Clientes</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="clientes.php">Lista clientes</a>
                        <a class="dropdown-item" href="clientes.php">Agregar cliente</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                
            <div class="nav-item dropdown active">
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
    <main class="content m-3">
        <h1 class="text-center">Registros de Kayak</h1>

        
        <form method="POST" action="kayaks.php" class="d-flex flex-column align-items-center" enctype="multipart/form-data">
            <div class="row w-75">
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="DNI">MODELO:</label>
                        <input class="form-control" type="text" id="MODELO" name="MODELO" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="TIPO">TIPO:</label>
                        <input class="form-control" type="text" id="TIPO" name="TIPO" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="COLOR">COLOR:</label>
                        <input class="form-control" type="text" id="COLOR" name="COLOR">
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
            <div class="row w-75 d-flex justify-content-center align-items-center">
                <div class="col-md-4">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label for="CLIENTE">CLIENTE:</label>
                        <div class="input-group mb-3">
                            <select class="form-select" id="CLIENTE" name="CLIENTE">
                                <option selected>-</option>
                                <?php 

                                $sql = "SELECT nombre, dni from kayak_clientes";

                                $conexion2 = new mysqli("localhost", "root", "", "registro-kayaks");
                                $clientes = $conexion2->query($sql);
            
                                while ($fila = $clientes->fetch_assoc()) {
                                    echo "<option value='" . $fila["dni"] . "'>" . $fila["nombre"] . " " . $fila["dni"]  . "</option>";
                                }
                                ?>
                            </select>
                        </div>
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
                    <label for="search">BUSCAR POR TIPO:</label>
                    <input class="form-control" type="search" id="search" name="search">
                </div>
                <div class="col-md-4 py-2">
                    <br>
                    <button type="submit" class="btn btn-primary btn-block" name="searchbtn">Buscar</button>
                </div>
            </div>
        </form>

        
        <table class="table m-3">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Color</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Fecha alta</th>
                    <th scope="col">Fecha baja</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["search"])) {

                    $conexion = new mysqli("localhost", "root", "", "registro-kayaks");
                    $search = $_POST["search"];

                    $sql = "SELECT kayak_kayaks.id, modelo, tipo, color, cliente, fecha_alta, fecha_baja, foto FROM kayak_kayaks
                    WHERE tipo LIKE '%$search%'";
                    
                    $resultado_search = $conexion->query($sql);

                    while ($fila = $resultado_search->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila["id"] . "</td>";
                        echo "<td>" . $fila["modelo"] . "</td>";
                        echo "<td>" . $fila["tipo"] . "</td>";
                        echo "<td>" . $fila["color"] . "</td>";
                        echo "<td>" . $fila["cliente"] . "</td>";
                        echo "<td>" . $fila["fecha_alta"] . "</td>";
                        echo "<td>" . $fila["fecha_baja"] . "</td>";
                        echo '<td><img src="' . $fila["foto"] . '" alt="Mi Imagen"></td>';
                        
                        echo "<td>
                        <form method='post' action='" . $_SERVER['PHP_SELF'] . "'>
                            <input type='hidden' name='eliminar' value='" . $fila["id"] . "'>
                            <input type='submit' value='Eliminar' class='btn btn-primary w-50'>
                        </form>
                        <form method='post' action='procesar_kayak_formulario.php'>
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
                        echo "<td>" . $fila["modelo"] . "</td>";
                        echo "<td>" . $fila["tipo"] . "</td>";
                        echo "<td>" . $fila["color"] . "</td>";
                        echo "<td>" . $fila["cliente"] . "</td>";
                        echo "<td>" . $fila["fecha_alta"] . "</td>";
                        echo "<td>" . $fila["fecha_baja"] . "</td>";
                        echo '<td><img src="' . $fila["foto"] . '" alt="Mi Imagen"></td>';
                        
                        echo "<td>
                        <form method='POST' action='" . $_SERVER['PHP_SELF'] . "'>
                            <input type='hidden' name='eliminar' value='" . $fila["id"] . "'>
                            <input type='submit' value='Eliminar' class='btn btn-primary w-75'>
                        </form>
                        <form method='POST' action='procesar_kayak_formulario.php'>
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
        <p class="text-center text-muted">© 2023 Guardería Náutica, Inc</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>