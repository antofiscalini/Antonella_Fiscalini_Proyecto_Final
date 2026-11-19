<?php
session_start();
require "conexion.php";

if (!isset($_SESSION["usuario"])) {
    header("Location: Adoptme.php");
    exit;
}

if ($_SESSION["rol"] != 1) {
    header("Location: panel.php");
    exit;
}

if (isset($_GET["buscar"]) && $_GET["buscar"] != "") {

    $buscar = "%" . $_GET["buscar"] . "%";

    $consulta = $conexionbd->prepare("SELECT * FROM usuarios WHERE usuario LIKE ?");
    $consulta->execute([$buscar]);

} else {

    $consulta = $conexionbd->query("SELECT * FROM usuarios");

}

$usuarios = $consulta->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de usuarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="container mt-5">

<h2>Administración de usuarios</h2>

<br>

<form method="GET" class="mb-3">

    <div class="input-group">

        <input
            type="text"
            name="buscar"
            class="form-control"
            placeholder="Buscar usuario">

        <button class="btn btn-primary">
            Buscar
        </button>

    </div>

</form>

<a href="crear_usuario.php" class="btn btn-success mb-3">
    Nuevo usuario
</a>

<table class="table table-bordered table-hover">

    <thead class="table-dark">

        <tr>

            <th>ID</th>

            <th>Usuario</th>

            <th>Rol</th>

            <th>Acciones</th>

        </tr>

    </thead>

    <tbody>

<?php 
    foreach($usuarios as $usuario){ 
?>

<tr>

    <td><?= $usuario["id"] ?></td>

    <td><?= $usuario["usuario"] ?></td>

    <td>

        <?php
        if($usuario["rol"] == 1){
            echo "Administrador";
        }else{
            echo "Usuario";
        }
        ?>

    </td>

    <td>

        <a href="editar_usuario.php?id=<?= $usuario["id"] ?>" class="btn btn-warning btn-sm">
            Editar
        </a>

        <a href="elimin_us.php?id=<?= $usuario["id"] ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('¿Eliminar usuario?')">

            Eliminar

        </a>

    </td>

</tr>

<?php } ?>

    </tbody>

</table>

<a href="panel.php" class="btn btn-secondary">
    Volver al panel
</a>

</body>
</html>