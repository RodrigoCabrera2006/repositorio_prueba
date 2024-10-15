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
$index = isset($_POST['index']) ? (int)$_POST['index'] : -1;

// Verificar que el índice es válido
if ($index >= 0 && $index < count($noticias)) {
    // Actualizar la noticia
    $noticias[$index]['titulo'] = $_POST['titulo'];
    $noticias[$index]['descripcion'] = $_POST['descripcion'];

    // Guardar las noticias actualizadas en el archivo JSON
    file_put_contents($jsonFile, json_encode($noticias, JSON_PRETTY_PRINT));
}

// Redirigir a la página principal o a la lista de noticias
header('Location: paginaPrincipal.php');
exit();
?>
