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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        html, body {
            height: 100%; /* Asegura que el body ocupe toda la altura */
            margin: 0; /* Elimina márgenes por defecto */
            display: flex;
            flex-direction: column; /* Establece la dirección del flex en columna */
        }

        .container {
            flex: 1; /* Esto permitirá que el contenedor principal ocupe el espacio restante */
        }
        .custom-header{
            background-color: #6a1f1f;
            color: #c0c0c0;
        }
        footer{
            background-color: #6a1f1f;
            color: #c0c0c0
        }
        .custom-header{
            background-color: #6a1f1f;
        }
        a .navbar-brand{
            background-color: #6a1f1f;
        }
        .container1{
            background-color: #6a1f1f;
        }


        /* Otras reglas CSS que necesites */
    </style>
    <script>
        // Función de confirmación de eliminación
        function confirmarEliminacion(event, form) {
            event.preventDefault(); // Evita que el formulario se envíe automáticamente
            const confirmacion = confirm('¿Estás seguro de que deseas eliminar esta noticia?');
            if (confirmacion) {
                form.submit(); // Si el administrador confirma, se envía el formulario
            }
        }
    </script>
</head>
<body>

<!-- Header -->
<header class="custom-header py-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="paginaPrincipal.php">
                <h1 class="m-0">Coop Design</h1>
            </a>
            <div class="d-flex">
                <a href="galeria.php" class="btn btn-outline-light me-2">Galería</a>
                <?php if ($isAdmin): ?>
                    <a href="crearNoticia.php" class="btn btn-outline-light me-2">Agregar Noticia</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['role'])): ?>
                    <a href="cerrarSesion.php" class="btn btn-outline-danger me-2">Cerrar Sesión</a>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                    <a href="informacion.html" class="btn btn-outline-success">Como Utilizar la pagina siendo administrador?</a>
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
                    <a href="detalleNoticia.php?index=<?php echo $index; ?>"class="a1" style="text-decoration: none; color: inherit;">
                        <?php if (!empty($noticia['imagen'])): ?>
                            <img src="<?php echo $noticia['imagen']; ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $noticia['titulo']; ?></h5>
                            <p class="card-text"><?php echo $noticia['descripcion']; ?></p>
                        </div>
                    </a>

                    <?php if ($isAdmin): ?>
                        <div class="card-body">
                            <a href="editarNoticia.php?index=<?php echo $index; ?>" class="btn btn-warning">Editar Noticia</a>
                            <form action="eliminarNoticia.php" method="POST" style="display:inline;" onsubmit="confirmarEliminacion(event, this);">
                                <input type="hidden" name="index" value="<?php echo $index; ?>">
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Footer -->
<footer class="text-center py-4">
    <div class="container">
        <h5>¡Seguinos en Instagram!</h5>
        <div class="social-icons">
            <a href="https://www.instagram.com/tecnica6moron_oficial/?hl=es" class="text-white mx-2" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <br>
        <hr class="my-4" />
        <br>
        <p>Contacto: <a href="mailto:example123@gmail.com" class="text-white">example123@gmail.com</a></p>
        <p>&copy; 2024 Coop Design. Todos los derechos reservados.</p>
    </div>
</footer>
<!-- Fin del Footer -->

</body>
</html>
