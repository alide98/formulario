<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Error: " . $conn->connect_error);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM invitados WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: consultar_invitado.php");
exit;
?>