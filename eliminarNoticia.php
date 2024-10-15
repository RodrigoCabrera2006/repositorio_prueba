<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: paginaPrincipal.php');
    exit();
}

// Ruta del archivo JSON
$jsonFile = 'noticias.json';

// Obtener el índice de la noticia a eliminar
$index = $_POST['index'];

// Leer el archivo JSON
$noticias = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Eliminar la noticia del array
if (isset($noticias[$index])) {
    if (file_exists($noticias[$index]['imagen']) && strpos($noticias[$index]['imagen'], 'uploads/') === 0) {
        unlink($noticias[$index]['imagen']); // Eliminar la imagen subida
    }
    array_splice($noticias, $index, 1); // Eliminar la noticia del array
    file_put_contents($jsonFile, json_encode($noticias)); // Guardar cambios
}

header('Location: paginaPrincipal.php');
?>
