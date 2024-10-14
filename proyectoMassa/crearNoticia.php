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
</head>
<body>
    <div class="container">
        <h1 class="my-4">Crear Nueva Noticia</h1>
        <form action="guardarNoticia.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="imagenUrl" class="form-label">URL de la Imagen</label>
                <input type="url" class="form-control" id="imagenUrl" name="imagenUrl">
            </div>
            <div class="mb-3">
                <label for="imagenArchivo" class="form-label">O subir una imagen</label>
                <input type="file" class="form-control" id="imagenArchivo" name="imagenArchivo" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Crear Noticia</button>
        </form>
    </div>
</body>
</html>
