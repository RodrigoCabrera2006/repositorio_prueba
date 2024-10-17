<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: paginaPrincipal.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="img/LogoChaca.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <h1 class="my-4" style="text-decoration: underline;">Crear Nueva Noticia</h1>
        <form action="guardarNoticia.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="titulo" class="form-label" style="text-decoration: underline;">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label" style="text-decoration: underline;">Descripción Breve</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
    </div>
    <div class="mb-3">
        <label for="detalles" class="form-label" style="text-decoration: underline;">Descripción Detallada</label>
        <textarea class="form-control" id="detalles" name="detalles" rows="5"></textarea>
    </div>
    <div class="mb-3">
        <label for="imagen" class="form-label" style="text-decoration: underline;">Imagen (opcional)</label>
        <input type="file" class="form-control" id="imagen" name="imagen">
    </div>
    <button type="submit" class="btn btn-primary">Publicar Noticia</button>
    <a type="button" class="btn btn-danger" href="paginaPrincipal.php">Volver</a>
</form>

    </div>
</body>
</html>
