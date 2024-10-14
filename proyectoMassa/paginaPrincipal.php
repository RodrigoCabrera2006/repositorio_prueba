<?php
session_start();

// Ruta del archivo JSON
$jsonFile = 'noticias.json';

// Leer el archivo JSON
$noticias = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];

// Verificar si el usuario es administrador
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias y Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <a href="galeria.php" class="btn btn-outline-dark me-2">Galería</a>
                <?php if ($isAdmin): ?>
                    <a href="crearNoticia.php" class="btn btn-outline-dark me-2">Agregar Noticia</a>
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
    <h1 class="my-4 text-center">Noticias y Eventos</h1>
    
    <div class="row d-flex justify-content-center">
        <?php foreach ($noticias as $index => $noticia): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?php echo $noticia['imagen']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $noticia['titulo']; ?></h5>
                        <p class="card-text"><?php echo $noticia['descripcion']; ?></p>

                        <!-- Botón de Editar -->
                        <?php if ($isAdmin): ?>
                            <a href="editarNoticia.php?index=<?php echo $index; ?>" class="btn btn-warning">Editar Noticia</a>
                            <form action="eliminarNoticia.php" method="POST" style="display:inline;">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
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
