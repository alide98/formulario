<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si hay búsqueda
$busqueda = "";
$resultados = [];

if (isset($_GET['q'])) {
    $busqueda = $_GET['q'];
    $sql = "SELECT * FROM invitados WHERE nombres LIKE ? OR apellidos LIKE ?";
    $stmt = $conn->prepare($sql);
    $param = "%" . $busqueda . "%";
    $stmt->bind_param("ss", $param, $param);
    $stmt->execute();
    $resultados = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de la Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styleConsultaInvitado.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="text-center mb-4">Resultados de la búsqueda</h2>

    <?php if ($resultados && $resultados->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Torre</th>
                        <th>Apartamento</th>
                        <th>Parentesco</th>
                        <th>Vehículo</th>
                        <th>Placa</th>
                        <th>Fecha Entrada</th>
                        <th>Hora Entrada</th>
                        <th>Motivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $resultados->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($fila['nombres']) ?></td>
                            <td><?= htmlspecialchars($fila['apellidos']) ?></td>
                            <td><?= htmlspecialchars($fila['torre']) ?></td>
                            <td><?= htmlspecialchars($fila['apto']) ?></td>
                            <td><?= htmlspecialchars($fila['parentesco']) ?></td>
                            <td><?= htmlspecialchars($fila['vehiculo']) ?></td>
                            <td><?= htmlspecialchars($fila['placa']) ?></td>
                            <td><?= htmlspecialchars($fila['fecha_entrada']) ?></td>
                            <td><?= htmlspecialchars($fila['hora_entrada']) ?></td>
                            <td><?= htmlspecialchars($fila['motivo']) ?></td>
                            <td class="text-center">
                                <a href="actualizar_invitado.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                <a href="eliminar_invitado.php?id=<?= $fila['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este registro?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($busqueda): ?>
        <div class="alert alert-warning text-center">No se encontraron resultados para "<strong><?= htmlspecialchars($busqueda) ?></strong>"</div>
    <?php else: ?>
        <div class="alert alert-info text-center">No se ha realizado ninguna búsqueda.</div>
    <?php endif; ?>
</div>

</body>
</html>