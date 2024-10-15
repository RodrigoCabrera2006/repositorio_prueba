<?php
session_start();

// Credenciales del administrador (puedes cambiar esto o almacenarlo en una base de datos)
$adminUsername = 'admin';
$adminPassword = 'admin123';

// Obtener los datos del formulario de inicio de sesión
$username = $_POST['username'];
$password = $_POST['password'];

// Conectar a la base de datos
$servername = "localhost"; // Cambia esto si tu base de datos está en otro servidor
$dbUsername = "root";      // Usuario de la base de datos
$dbPassword = "";          // Contraseña de la base de datos
$dbname = "usuarios";      // Nombre de tu base de datos

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Si el usuario es el administrador
if ($username === $adminUsername && $password === $adminPassword) {
    // Asignar rol de administrador
    $_SESSION['role'] = 'admin';
    header('Location: paginaPrincipal.php');
    exit();
}

// Verificar credenciales de usuario regular
$sql = "SELECT * FROM login WHERE username = ?"; // Cambiado a 'login'

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta SQL: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Verificar la contraseña en texto plano
    $user = $result->fetch_assoc();
    if ($password === $user['password']) { // Comparar directamente con la contraseña
        // Iniciar sesión como usuario regular
        $_SESSION['role'] = 'user';
        header('Location: paginaPrincipal.php');
    } else {
        // Contraseña incorrecta
        header('Location: condiciones/contraIncorrecta.html');
    }
} else {
    // Nombre de usuario no encontrado
    header('Location: condiciones/usuarioNoEncontrado.html');
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
