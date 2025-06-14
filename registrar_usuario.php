<?php
$servername = "localhost";
$username = "root";
$password = ""; // si tu instalación tiene password, cámbialo aquí
$dbname = "proyecto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['username'];
    $contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT);
  
    // Verificar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h1>Error: el nombre de usuario ya existe</h1>";
        echo "<a href='registro_usuario.php'>Intentar nuevamente</a>";
    } else {
        // Insertar nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (usuario, contrasena) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $contrasena);

        if ($stmt->execute()) {
            echo "<h1>Registro exitoso</h1>";
            echo "<p>Serás redirigido en 5 segundos...</p>";
            echo "<meta http-equiv='refresh' content='5;url=login.php'>";
        } else {
            echo "<h1>Error al guardar el usuario</h1>";
            echo "<p>" . $stmt->error . "</p>";
        }
    }

    $stmt->close();
}

$conn->close();

?>
