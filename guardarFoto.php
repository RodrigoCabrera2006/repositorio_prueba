<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: paginaPrincipal.php');
    exit();
}

// Manejar la subida de la imagen
if ($_FILES['imagen']['name']) {
    $targetDir = "uploads/"; // Asegúrate de que este directorio existe
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $targetFile = $targetDir . basename($_FILES['imagen']['name']);
    
    // Mover la imagen subida a la carpeta correcta
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile)) {
        $descripcion = $_POST['descripcion'];
        
        // Leer las fotos actuales desde el archivo JSON
        $jsonFile = 'galeria.json';
        $galeria = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

        // Agregar la nueva foto a la galería
        $galeria[] = [
            'imagen' => $targetFile,
            'descripcion' => $descripcion
        ];

        // Guardar la galería en el archivo JSON
        file_put_contents($jsonFile, json_encode($galeria, JSON_PRETTY_PRINT));

        // Redirigir a la galería después de agregar la foto
        header('Location: galeria.php');
        exit();
    } else {
        echo "Error al subir la imagen.";
    }
}
?>
