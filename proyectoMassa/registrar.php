<?php
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
    $confirm_pass = $_POST['confirm_password'];

    // Verificar si las contraseñas coinciden
    if ($pass !== $confirm_pass) {
        header("Location: condiciones/contraNoCoincide.html");
        exit();
    }

    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: condiciones/usuarioYaExiste.html");
        exit();
    }

    // Insertar nuevo usuario en la base de datos sin encriptar la contraseña
    $stmt = $conn->prepare("INSERT INTO login (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $pass); // Utiliza la contraseña sin encriptar

    if ($stmt->execute()) {
        header("Location: condiciones/registroCorrecto.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Cierra el statement
}

$conn->close();
?>
