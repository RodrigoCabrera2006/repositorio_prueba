<?php
session_start();

// Ruta del archivo JSON
$jsonFile = 'galeria.json';

// Leer el archivo JSON
$galeria = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: paginaPrincipal.php');
    exit();
}

// Obtener el índice de la foto a editar
$index = isset($_GET['index']) ? (int)$_GET['index'] : -1;
$foto = ($index >= 0 && $index < count($galeria)) ? $galeria[$index] : null;

// Si la foto no existe, redirigir
if (!$foto) {
    header('Location: galeria.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="my-4">Editar Foto</h1>
    <form action="guardarEdicionFoto.php" method="POST">
        <input type="hidden" name="index" value="<?php echo $index; ?>">
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo htmlspecialchars($foto['descripcion']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen Actual</label>
            <img src="<?php echo $foto['imagen']; ?>" class="img-fluid" alt="Imagen Actual">
        </div>
        <div class="mb-3">
            <label for="nueva_imagen" class="form-label">Subir Nueva Imagen (opcional)</label>
            <input type="file" class="form-control" id="nueva_imagen" name="nueva_imagen" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
