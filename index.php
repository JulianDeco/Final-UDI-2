<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión guardería náutica</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
<<<<<<< HEAD
        <a class="navbar-brand" href="index.php"><img src="statics/kayaking.png" alt="" class="logo-guarderia"></a>
=======
        <a class="navbar-brand" href="index.php"><img src="statics/logo.webp" alt="" class="logo-guarderia"></a>
>>>>>>> f305a0f664fa3f4bcb7e7f876296753237ab4cdc
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Inicio<span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
                <div class="nav-item dropdown">
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
    <main class="content bg-secondary pb-3 mb-3">
        <div class="text-center my-2 p-3 text-white">
            <h1>Sistema integral - Administración guardería náutica</h1>
       </div>

       <div class="container bg-white p-3">
            <h2 class="text-left m-3">Guardería Náutica</h2>
            <p class="m-4">Sistema creado con el fin de administrar los clientes de la guardería y los kayaks a nombre de estos clientes</p>

            <div class="cards d-flex flex-column">
                <div class="card m-3">
                    <div class="card-header">
                        Clientes
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Administración de clientes</h5>
                        <p class="card-text">Podés <strong>AGREGAR, ELIMINAR O EDITAR</strong> tu lista de clientes.</p>
                        <a href="#" class="btn btn-primary">CLIENTES</a>
                    </div>
                </div>

                <div class="card m-3">
                    <div class="card-header">
                        Kayaks
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Administración de kayaks</h5>
                        <p class="card-text">Podés <strong>AGREGAR, ELIMINAR O EDITAR</strong> kayaks de tus clientes.</p>
                        <p class="card-text">Para agregar un kayak, este debe asociarse a un cliente.</p>
                        <a href="#" class="btn btn-primary">KAYAKS</a>
                    </div>
                    </div>
                </div>
            </div>
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