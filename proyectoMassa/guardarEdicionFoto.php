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
    // Sanitizar la descripción antes de guardarla
    $galeria[$index]['descripcion'] = htmlspecialchars($_POST['descripcion'], ENT_QUOTES, 'UTF-8');

    // Manejar la subida de una nueva imagen, si se proporciona
    if ($_FILES['nueva_imagen']['name']) {
        // Verificar que no hubo errores en la subida del archivo
        if ($_FILES['nueva_imagen']['error'] === UPLOAD_ERR_OK) {
            $targetDir = "uploads/"; // Directorio donde se guardan las imágenes
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true); // Permisos seguros
            }

            // Renombrar el archivo para evitar duplicados
            $fileName = uniqid() . "-" . basename($_FILES['nueva_imagen']['name']);
            $targetFile = $targetDir . $fileName;

            // Mover el archivo subido al directorio de destino
            if (move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $targetFile)) {
                // Actualizar la ruta de la imagen si la subida fue exitosa
                $galeria[$index]['imagen'] = $targetFile;
            } else {
                // Error al mover el archivo
                echo 'Error al subir la imagen.';
                exit();
            }
        } else {
            // Error en la subida del archivo
            echo 'Error en la subida de la imagen: ' . $_FILES['nueva_imagen']['error'];
            exit();
        }
    }

    // Guardar los cambios en el archivo JSON
    if (file_put_contents($jsonFile, json_encode($galeria, JSON_PRETTY_PRINT))) {
        // Redirigir a la galería después de guardar los cambios
        header('Location: galeria.php');
        exit();
    } else {
        // Error al guardar el archivo JSON
        echo 'Error al guardar los cambios.';
        exit();
    }
} else {
    // Índice inválido
    echo 'Índice de foto inválido.';
    exit();
}
?>
