<?php
session_start();
$jsonFile = 'noticias.json';

// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: paginaPrincipal.php');
    exit();
}

// Leer las noticias
$noticias = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Obtener el índice de la noticia que se va a editar
$index = isset($_GET['index']) ? (int)$_GET['index'] : -1;
$noticia = $index >= 0 && $index < count($noticias) ? $noticias[$index] : null;

// Si la noticia no existe, redirigir
if (!$noticia) {
    header('Location: paginaPrincipal.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Noticia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1 class="my-4">Editar Noticia</h1>
    <form action="guardarEdicion.php" method="POST">
        <input type="hidden" name="index" value="<?php echo $index; ?>">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($noticia['titulo']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="5" required><?php echo htmlspecialchars($noticia['descripcion']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
