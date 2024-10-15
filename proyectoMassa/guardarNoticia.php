<?php
// Ruta del archivo JSON
$jsonFile = 'noticias.json';

// Leer el archivo JSON
$noticias = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Obtener datos del formulario
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$detalles = !empty($_POST['detalles']) ? $_POST['detalles'] : ''; // Campo detalles

// Manejar la subida de imagen si existe
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
    $targetDir = "uploads/"; // Directorio donde se guardan las imágenes
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $targetFile = $targetDir . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile);
    $imagen = $targetFile;
} else {
    $imagen = ''; // Sin imagen
}

// Crear una nueva noticia
$noticias[] = [
    'titulo' => $titulo,
    'descripcion' => $descripcion,
    'detalles' => $detalles,
    'imagen' => $imagen
];

// Guardar la nueva noticia en el archivo JSON
file_put_contents($jsonFile, json_encode($noticias, JSON_PRETTY_PRINT));

// Redirigir de nuevo a la página principal
header('Location: paginaPrincipal.php');
exit();
?>
