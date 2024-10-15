<?php
session_start();

// Ruta del archivo JSON
$jsonFile = 'noticias.json';

// Leer el archivo JSON
$noticias = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Obtener el índice de la noticia desde la URL
$index = isset($_GET['index']) ? (int)$_GET['index'] : -1;

// Verificar que la noticia existe
if ($index < 0 || $index >= count($noticias)) {
    echo "Noticia no encontrada";
    exit();
}

// Obtener los detalles de la noticia
$noticia = $noticias[$index];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $noticia['titulo']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .image-container {
    text-align: center; /* Centra horizontalmente el contenido dentro del contenedor */
}

.img-custom {
    display: inline-block; /* Cambia a bloque en línea para que funcione con el centrado */
    max-width: 100%;      /* Asegura que la imagen no exceda el contenedor */
    height: auto;         /* Mantiene la proporción */
}


    </style>
</head>
<body>

<!-- Header -->
<header class="custom-header text-dark py-3 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <a class="navbar-brand" href="paginaPrincipal.php">
                <h1 class="m-0">Coop Design</h1>
            </a>

            <!-- Botones minimalistas para Home, Galería e Iniciar sesión -->
            <div class="d-flex">
                <a href="paginaPrincipal.php" class="btn btn-outline-dark me-2">Volver</a>
            </div>
        </div>
    </div>
</header>
<!-- Fin Header -->



<div class="container my-5">
    <h1 style="text-align:center; font-size:70px;"><?php echo $noticia['titulo']; ?></h1>

    <!-- Mostrar la imagen solo si existe -->
    <?php if (!empty($noticia['imagen'])): ?>
        <div class="image-container">
            <img src="<?php echo $noticia['imagen']; ?>" class="img-fluid img-custom mb-4" alt="Imagen de la Noticia" style="width:700px; height:500px;  object-fit: cover;">
        </div>

    <?php endif; ?>


    <!-- Mostrar los detalles solo si existen -->
    <p style="font-size:30px;"><?php echo isset($noticia['detalles']) ? nl2br($noticia['detalles']) : 'No hay detalles adicionales para esta noticia.'; ?></p>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4">
    <div class="container">
        <h5>¡Seguinos en Instagram!</h5>
        <div class="social-icons">
            <a href="https://www.instagram.com/tecnica6moron_oficial/?hl=es" class="text-white mx-2" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <hr class="my-4" />
        <p>Contacto: <a href="mailto:example123@gmail.com" class="text-white">example123@gmail.com</a></p>
        <p>&copy; 2024 Coop Design. Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>
