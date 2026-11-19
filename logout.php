<?php
session_start();

// Vacía todas las variables de sesión
$_SESSION = [];

// Destruye la sesión
session_destroy();

// Redirige al login
header("Location: index.php");
exit;
?>
