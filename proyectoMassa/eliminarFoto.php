<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: paginaPrincipal.php');
    exit();
}

// Ruta del archivo JSON
$jsonFile = 'galeria.json';

// Leer el archivo JSON
$galeria = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Obtener el índice de la foto a eliminar
$index = $_POST['index'];

// Verificar que el índice es válido
if (isset($galeria[$index])) {
    // Obtener el path de la imagen
    $imagenPath = $galeria[$index]['imagen'];
    
    // Eliminar la imagen del servidor
    if (file_exists($imagenPath)) {
        unlink($imagenPath); // Borrar la imagen del servidor
    }
    
    // Eliminar la entrada del array
    array_splice($galeria, $index, 1);
    
    // Guardar el archivo JSON actualizado
    file_put_contents($jsonFile, json_encode($galeria, JSON_PRETTY_PRINT));
}

// Redirigir a la galería después de eliminar la foto
header('Location: galeria.php');
exit();
?>
