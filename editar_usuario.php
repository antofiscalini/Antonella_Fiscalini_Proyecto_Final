<?php
session_start();
require "conexion.php";

// Solo puede entrar un administrador
if (!isset($_SESSION["usuario"])) {
    header("Location: Adoptme.php");
    exit;
}

if ($_SESSION["rol"] != 1) {
    header("Location: panel.php");
    exit;
}

// Si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["id"];
    $usuario = trim($_POST["usuario"]);
    $rol = $_POST["rol"];

    // Si escribió una contraseña nueva
    if ($_POST["clave"] != "") {

        $clave = password_hash($_POST["clave"], PASSWORD_DEFAULT);

        $consulta = $conexionbd->prepare("
            UPDATE usuarios
            SET usuario = ?, clave = ?, rol = ?
            WHERE id = ?
        ");

        $consulta->execute([$usuario, $clave, $rol, $id]);

    } else {

        // Si dejó la contraseña vacía, no la cambia

        $consulta = $conexionbd->prepare("
            UPDATE usuarios
            SET usuario = ?, rol = ?
            WHERE id = ?
        ");

        $consulta->execute([$usuario, $rol, $id]);
    }

    header("Location: admin_usuarios.php");
    exit;
}

// Obtiene el usuario
$id = $_GET["id"];

$consulta = $conexionbd->prepare("SELECT * FROM usuarios WHERE id = ?");
$consulta->execute([$id]);

$usuario = $consulta->fetch();

if (!$usuario) {
    die("Usuario no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Editar usuario</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="panel.css">

</head>

<body class="container mt-5">

<h2>Editar usuario</h2>

<form method="POST">

    <input
        type="hidden"
        name="id"
        value="<?php echo $usuario["id"]; ?>">

    <div class="mb-3">

        <label>Usuario</label>

        <input
            type="text"
            name="usuario"
            class="form-control"
            value="<?php echo $usuario["usuario"]; ?>"
            required>

    </div>

    <div class="mb-3">

        <label>Nueva contraseña</label>

        <input
            type="password"
            name="clave"
            class="form-control">

        <small class="text-muted">
            Dejar vacía para mantener la actual.
        </small>

    </div>

    <div class="mb-3">

        <label>Rol</label>

        <select
            name="rol"
            class="form-control">

            <option value="1"
            <?php
            if($usuario["rol"]==1){
                echo "selected";
            }
            ?>
            >
            Administrador
            </option>

            <option value="0"
            <?php
            if($usuario["rol"]==0){
                echo "selected";
            }
            ?>
            >
            Usuario
            </option>

        </select>

    </div>

    <button class="btn btn-success">
        Guardar cambios
    </button>

    <a
        href="admin_usuarios.php"
        class="btn btn-secondary">

        Cancelar

    </a>

</form>

</body>
</html>