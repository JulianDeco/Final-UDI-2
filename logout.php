<?php
session_start(); // Inicia la sesión o reanuda la sesión actual
// Destruir la sesión
session_destroy(); // Cierra y destruye la sesión actual
// Redirigir a la página de inicio de sesión
header("Location: login.php"); // Redirige al usuario a la página de inicio de sesión
exit; // Detiene la ejecución del script después de redirigir
?>
