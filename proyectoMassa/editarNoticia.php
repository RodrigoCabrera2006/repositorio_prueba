<?php
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: paginaPrincipal.php');
    exit();
}

// Ruta del archivo JSON
$jsonFile = 'noticias.json';

// Obtener el índice de la noticia a editar
$index = isset($_GET['index']) ? (int)$_GET['index'] : -1;

// Leer el archivo JSON
$noticias = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Verificar que el índice es válido
if ($index < 0 || $index >= count($noticias)) {
    echo "Noticia no encontrada.";
    exit();
}

// Obtener los datos de la noticia a editar
$noticia = $noticias[$index];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $detalles = $_POST['detalles'];

    // Manejar la imagen si se ha subido una nueva
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . basename($_FILES['imagen']['name']);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile);
        $imagen = $targetFile;
    } else {
        // Si no se sube una nueva imagen, conservar la imagen existente
        $imagen = $noticia['imagen'];
    }

    // Verificar si se desea eliminar la imagen existente
    if (isset($_POST['eliminar_imagen']) && $_POST['eliminar_imagen'] == 'on') {
        // Eliminar la imagen del servidor
        if (file_exists($noticia['imagen'])) {
            unlink($noticia['imagen']);
        }
        $imagen = ''; // Limpiar la variable imagen
    }

    // Actualizar la noticia con los nuevos datos
    $noticias[$index] = [
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'detalles' => $detalles,
        'imagen' => $imagen
    ];

    // Guardar el archivo JSON actualizado
    file_put_contents($jsonFile, json_encode($noticias, JSON_PRETTY_PRINT));

    // Redirigir de nuevo a la página principal
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
    <link rel="icon" href="img/LogoChaca.png" type="image/x-icon">
</head>
<body>

<div class="container my-5">
    <h1 class="text-center">Editar Noticia</h1>

    <form action="editarNoticia.php?index=<?php echo $index; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $noticia['titulo']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción Breve</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $noticia['descripcion']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="detalles" class="form-label">Descripción Detallada</label>
            <textarea class="form-control" id="detalles" name="detalles" rows="5"><?php echo $noticia['detalles']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen Actual</label><br>
            <?php if (!empty($noticia['imagen'])): ?>
                <img src="<?php echo $noticia['imagen']; ?>" alt="Imagen actual" style="max-width: 200px;"><br>
            <?php endif; ?>
            <label for="imagen" class="form-label">Cambiar Imagen (opcional)</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
            <div class="form-check mt-2">
                <input class="form-check-input" type="checkbox" id="eliminar_imagen" name="eliminar_imagen">
                <label class="form-check-label" for="eliminar_imagen">
                    Eliminar imagen existente
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
