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
    <link rel="icon" href="img/LogoChaca.png" type="image/x-icon">
    
    <style>
        /* Estilos para el modo oscuro */

        .hovereffect {
            position: relative;
            overflow: hidden;
            height: 300px;
        }

        .hovereffect img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            height: 100%;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .hovereffect:hover img {
            transform: translate(-50%, -50%) scale(1.1);
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            pointer-events: none;
        }

        .hovereffect:hover .overlay {
            opacity: 1;
        }

        .overlay h2 {
            color: white;
            font-size: 24px;
            text-align: center;
            margin: 0;
        }

        .modal-body img {
            width: 100%;
            height: auto;
            max-height: 100%;
            object-fit: cover;
        }
         .custom-header{
            background-color: #6a1f1f;
            color: #c0c0c0;
        }
        footer{
            min-height: 70px;
            background-color: #6a1f1f;
            color: #c0c0c0; 
            position:absolute;
            bottom:0%;
            width:100%;
            
        }
        .d-flex{
            background-color: #6a1f1f;
        }
        a {
            background-color: #6a1f1f;
        }
        .container1{
            background-color: #6a1f1f;
        }

    </style>
    
    <script>
        // Función para confirmar eliminación
        function confirmarEliminacion(event, index) {
            event.preventDefault();
            if (confirm('¿Estás seguro de que deseas eliminar esta foto?')) {
                document.getElementById('form-eliminar-' + index).submit();
            }
        }

        // Función para establecer la imagen en el modal
        function setModalImage(imageSrc, description) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModalLabel').textContent = description;
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
                <a href="paginaPrincipal.php" class="btn btn-outline-light me-2">Página Principal</a>
                <?php if (isset($_SESSION['role'])): ?>
                    <a href="cerrarSesion.php" class="btn btn-outline-danger me-2">Cerrar Sesión</a>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                    <a href="informacion.html" class="btn btn-outline-primary">Como Utilizar la pagina siendo administrador?</a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</header>
<!-- Fin Header -->

<div class="container">

    <h1 class="my-4 text-center">Galería de Fotos de Cooperadora</h1>
    <?php if ($isAdmin): ?>
    <div class="text-center mb-3">
        <a href="agregarFoto.php" class="btn btn-dark">Agregar Foto</a>
    </div>
    <?php endif; ?>

    <div class="my-5"></div>

    <!-- Mostrar imágenes desde el archivo JSON -->
    <div class="row mb-4">
        <?php foreach ($galeria as $index => $foto): ?>
            <div class="col-md-4">
                <div class="hovereffect">
                    <img 
                        src="<?php echo $foto['imagen']; ?>" 
                        class="img-fluid" 
                        alt="<?php echo $foto['descripcion']; ?>" 
                        data-bs-toggle="modal" 
                        data-bs-target="#imageModal"
                        onclick="setModalImage('<?php echo $foto['imagen']; ?>', '<?php echo $foto['descripcion']; ?>')"
                        style="object-fit: contain;"
                    >
                    <div class="overlay">
                        <h2><?php echo $foto['descripcion']; ?></h2>
                    </div>
                </div>
                <?php if ($isAdmin): ?>
                    <a href="editarFoto.php?index=<?php echo $index; ?>" class="btn btn-warning mt-2">Editar Foto</a>
                    <form id="form-eliminar-<?php echo $index; ?>" action="eliminarFoto.php" method="POST" style="display:inline;">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="button" class="btn btn-danger mt-2" onclick="confirmarEliminacion(event, <?php echo $index; ?>)">Eliminar Foto</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Modal para ampliar la imagen -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Imagen Ampliada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="img-fluid" alt="">
            </div>
        </div>
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
        <hr class="my-4" />
        <p>Contacto: <a href="mailto:example123@gmail.com" class="text-white">example123@gmail.com</a></p>
        <p>&copy; 2024 Coop Design. Todos los derechos reservados.</p>
    </div>
</footer>

</body>
</html>
