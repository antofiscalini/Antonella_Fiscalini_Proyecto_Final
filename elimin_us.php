<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require "conexion.php";

// Verifica que haya iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: Adoptme.php");
    exit;
}

// Verifica que sea administrador
if ($_SESSION["rol"] != 1) {
    header("Location: panel.php");
    exit;
}

// Verifica que llegue un id
if (!isset($_GET["id"])) {
    header("Location: admin_usuarios.php");
    exit;
}

$id = $_GET["id"];

// Evita que un administrador se elimine a sí mismo
if ($id == $_SESSION["id"]) {
    header("Location: admin_usuarios.php");
    exit;
}

// Elimina el usuario
$consulta = $conexionbd->prepare("DELETE FROM usuarios WHERE id = ?");
$consulta->execute([$id]);

// Vuelve al listado
header("Location: admin_usuarios.php");
exit;
?>