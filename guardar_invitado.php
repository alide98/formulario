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
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $torre = $_POST['torre'];
    $apto = $_POST['apto'];
    $parentesco = $_POST['parentesco'];
    $vehiculo = $_POST['vehiculo'];
    $placa = $_POST['placa'];
    $fecha_entrada = $_POST['fecha_entrada'];
    $hora_entrada = $_POST['hora_entrada'];
    $motivo = $_POST['motivo'];

    $stmt = $conn->prepare("INSERT INTO invitados (nombres, apellidos, torre, apto, parentesco, vehiculo, placa, fecha_entrada, hora_entrada, motivo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $nombres, $apellidos, $torre, $apto, $parentesco, $vehiculo, $placa, $fecha_entrada, $hora_entrada, $motivo);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header("Location: registro_invitado.html?msg=Registro+exitoso");

        exit;
    } else {
        echo "<h1>Error al guardar el registro</h1>";
    }

    $stmt->close();
}

$conn->close();

?>
