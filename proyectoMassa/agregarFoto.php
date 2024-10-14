<?php
session_start();
// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    ('Location: paginaPrincipal.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
<header class="custom-header text-dark py-3 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="paginaPrincipal.php">
                <h1 class="m-0">Coop Design</h1>
            </a>
            <div class="d-flex">
                <a href="paginaPrincipal.php" class="btn btn-outline-dark me-2">Home</a>
                <a href="galeria.php" class="btn btn-outline-dark me-2">Galería</a>
                <a href="cerrarSesion.php" class="btn btn-outline-danger">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</header>
<!-- Fin Header -->

<div class="container">
    <h1 class="my-4 text-center">Agregar Foto a la Galería</h1>
    <form action="guardarFoto.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción de la Foto</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Subir Imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Foto</button>
    </form>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <h5>¡Seguinos en Instagram!</h5>
        <div class="social-icons">
            <a href="https://www.instagram.com/tecnica6moron_oficial/?hl=es" class="text-white mx-2" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <hr class="my-4" />
        <p>Contacto: <a href="mailto:example123@gmail.com" class="text-white">example123@gmail.com</a></p>
        <p>&copy; 2024 Coop Design. Todos los derechos reservados.</p>
    </div>
</footer>
<!-- Fin Footer -->

</body>
</html>
