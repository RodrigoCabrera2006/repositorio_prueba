<?php
session_start();

// Ruta del archivo JSON
$jsonFile = 'galeria.json';

// Leer el archivo JSON
$galeria = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Verificar si el usuario es administrador
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Imágenes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Espacio personalizado entre filas de imágenes */
        .row {
            margin-bottom: 30px; /* Ajusta este valor para controlar el espacio */
        }
        .hovereffect {
            position: relative;
            overflow: hidden;
        }
        .hovereffect img {
            display: block;
            transition: transform 0.3s ease; /* Para el zoom */
            width: 100%; /* Asegura que la imagen ocupe el ancho completo */
            height: auto; /* Mantiene la relación de aspecto */
        }
        .hovereffect:hover img {
            transform: scale(1.1); /* Zoom al pasar el cursor */
            filter: blur(2px); /* Aplicar efecto difuminado */
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Fondo semitransparente negro */
            opacity: 0; /* Ocultar por defecto */
            transition: opacity 0.3s ease; /* Transición suave para la opacidad */
            display: flex; /* Usar flexbox para centrar el texto */
            justify-content: center; /* Centrar horizontalmente */
            align-items: center; /* Centrar verticalmente */
        }
        .hovereffect:hover .overlay {
            opacity: 1; /* Mostrar overlay al pasar el cursor */
        }
        .overlay h2 {
            color: white; /* Color del texto */
            font-size: 24px; /* Tamaño de fuente */
            text-align: center; /* Centrar el texto */
            margin: 0; /* Sin margen */
        }
    </style>
</head>
<body>

<!-- Header -->
<header class="custom-header text-dark py-3 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="paginaPrincipal.php">
                <h1 class="m-0">Coop Design</h1>
            </a>
            <div class="d-flex">
                <a href="paginaPrincipal.php" class="btn btn-outline-dark me-2">Página Principal</a>
                <?php if ($isAdmin): ?>
                    <a href="agregarFoto.php" class="btn btn-outline-dark me-2">Agregar Foto</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['role'])): ?>
                    <a href="cerrarSesion.php" class="btn btn-outline-danger">Cerrar Sesión</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>
<!-- Fin Header -->

<div class="container">
    <h1 class="my-4 text-center">Galería de Fotos de Cooperadora</h1>
    <div class="my-5"></div>

    <!-- Mostrar imágenes desde el archivo JSON -->
    <div class="row mb-4">
        <?php foreach ($galeria as $index => $foto): ?>
            <div class="col-md-4">
                <div class="hovereffect">
                    <img src="<?php echo $foto['imagen']; ?>" class="img-fluid" alt="<?php echo $foto['descripcion']; ?>">
                    <div class="overlay">
                        <h2><?php echo $foto['descripcion']; ?></h2>
                    </div>
                </div>
                <?php if ($isAdmin): ?>
                    <a href="editarFoto.php?index=<?php echo $index; ?>" class="btn btn-warning mt-2">Editar Foto</a>
                    <form action="eliminarFoto.php" method="POST" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" class="btn btn-danger mt-2">Eliminar Foto</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
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
<!-- Fin Footer -->

</body>
</html>
