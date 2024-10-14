<?php
// Ruta del archivo JSON
$jsonFile = 'noticias.json';

// Obtener los datos del formulario
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$imagenUrl = $_POST['imagenUrl'];

// Manejar la subida de la imagen
if ($_FILES['imagenArchivo']['name']) {
    $targetDir = "uploads/";
    $imageName = basename($_FILES['imagenArchivo']['name']);
    $targetFile = $targetDir . $imageName;
    
    // Crear el directorio 'uploads' si no existe
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Mover la imagen subida a la carpeta correcta
    if (move_uploaded_file($_FILES['imagenArchivo']['tmp_name'], $targetFile)) {
        $imagenUrl = $targetFile; // Usar la ruta de la imagen subida
    }
}


// Leer el archivo JSON actual
$noticias = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Agregar la nueva noticia
$noticiaNueva = [
    'titulo' => $titulo,
    'descripcion' => $descripcion,
    'imagen' => $imagenUrl
];
$noticias[] = $noticiaNueva;

// Guardar las noticias en el archivo JSON
file_put_contents($jsonFile, json_encode($noticias));

// Redirigir de nuevo a la página principal
header('Location: paginaPrincipal.php');
?>
