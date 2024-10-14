<?php
session_start();
$jsonFile = 'galeria.json';

// Verificar si el usuario es administrador
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: paginaPrincipal.php');
    exit();
}

// Leer el archivo JSON
$galeria = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Obtener el índice de la foto que se va a editar
$index = isset($_POST['index']) ? (int)$_POST['index'] : -1;

// Verificar que el índice es válido
if ($index >= 0 && $index < count($galeria)) {
    // Actualizar la descripción
    $galeria[$index]['descripcion'] = $_POST['descripcion'];

    // Manejar la subida de una nueva imagen, si se proporciona
    if ($_FILES['nueva_imagen']['name']) {
        $targetDir = "uploads/"; // Directorio donde se guardan las imágenes
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . basename($_FILES['nueva_imagen']['name']);
        move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $targetFile);
        
        // Actualizar la ruta de la imagen
        $galeria[$index]['imagen'] = $targetFile;
    }

    // Guardar los cambios en el archivo JSON
    file_put_contents($jsonFile, json_encode($galeria, JSON_PRETTY_PRINT));
}

// Redirigir a la galería después de guardar los cambios
header('Location: galeria.php');
exit();
?>
