<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: Adoptme.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <span class="navbar-brand mb-0 h1">Mi Panel</span>
            <a href="logout.php" class="btn btn-light btn-sm">Salir</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h1 class="h4">Bienvenido, <?php echo $_SESSION["usuario"]; ?></h1>
                <p class="mb-0 text-secondary">Iniciaste correctamente. Ahora podes entrar a la página principal.</p>

                <hr>

                <a href="Adoptme.php" class="btn btn-primary">Ver adopción de animales</a>

                <?php if ($_SESSION["rol"] == 1) { ?>

                    <a href="admin_usuarios.php" class="btn btn-warning">
                        Administrar usuarios
                    </a>

                <?php } ?>
            </div>
        </div>
    </div>
    

</body>
</html>
