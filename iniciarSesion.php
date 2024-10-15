<?php
//TODO ESTO ESTA HECHO CON LA BASE DE DATOS DE LA CARPETA DB (bbdd muy simple)

session_start();

// Conectar a la base de datos
$servername = "localhost";
$username = "root"; // Usuario por defecto de XAMPP
$password = ""; // Contraseña por defecto de XAMPP
$dbname = "usuarios";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Consultar la base de datos
    $sql = "SELECT * FROM login WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Credenciales correctas
        $_SESSION['username'] = $user; // Guardar el nombre de usuario en la sesión
        header("Location: paginaPrincipal.php"); // Redirigir a la pagina principal
        exit();
    } else {
        // Credenciales incorrectas
        echo "Nombre de usuario o contraseña incorrectos.";
        header("Location: condiciones/inicioSesionIncorrecto.html");
    }
}

$conn->close();
?>
