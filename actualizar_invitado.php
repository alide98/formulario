<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

$mensaje = "";

// Si recibe ID por GET, carga datos
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $resultado = $conn->query("SELECT * FROM invitados WHERE id=$id");
  $invitado = $resultado->fetch_assoc();
}

// Si se envía el formulario (POST), actualiza datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  $nombres = $_POST['nombres'];
  $apellidos = $_POST['apellidos'];
  $torre = $_POST['torre'];
  $apto = $_POST['apto'];
  $parentesco = $_POST['parentesco'];
  $vehiculo = $_POST['vehiculo'];
  $placa = $_POST['placa'];
  $fecha = $_POST['fecha_entrada'];
  $hora = $_POST['hora_entrada'];
  $motivo = $_POST['motivo'];

  $stmt = $conn->prepare("UPDATE invitados SET nombres=?, apellidos=?, torre=?, apto=?, parentesco=?, vehiculo=?, placa=?, fecha_entrada=?, hora_entrada=?, motivo=? WHERE id=?");
  $stmt->bind_param("ssssssssssi", $nombres, $apellidos, $torre, $apto, $parentesco, $vehiculo, $placa, $fecha, $hora, $motivo, $id);

  if ($stmt->execute()) {
    $mensaje = "✅ Invitado actualizado correctamente.";
    $resultado = $conn->query("SELECT * FROM invitados WHERE id=$id");
    $invitado = $resultado->fetch_assoc();
  } else {
    $mensaje = "❌ Error al actualizar los datos.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Actualizar Invitado</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="styleActualizarInvitado.css">
</head>

<body>
  <div class="container py-5">
    <div class="card p-4 mx-auto shadow-lg">
      <h2 class="text-center mb-4 text-light">
        <i class="bi bi-pencil-square"></i> Actualizar Invitado
      </h2>

      <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info text-center"><?= $mensaje ?></div>
      <?php endif; ?>

      <form method="POST">
        <input type="hidden" name="id" value="<?= $invitado['id'] ?>">

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label text-light">Nombres</label>
            <input type="text" name="nombres" value="<?= htmlspecialchars($invitado['nombres']) ?>" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-light">Apellidos</label>
            <input type="text" name="apellidos" value="<?= htmlspecialchars($invitado['apellidos']) ?>" class="form-control" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label text-light">Torre</label>
            <input type="text" name="torre" value="<?= htmlspecialchars($invitado['torre']) ?>" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-light">Apartamento</label>
            <input type="text" name="apto" value="<?= htmlspecialchars($invitado['apto']) ?>" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Parentesco</label>
          <input type="text" name="parentesco" value="<?= htmlspecialchars($invitado['parentesco']) ?>" class="form-control" required>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label text-light">Vehículo</label>
            <input type="text" name="vehiculo" value="<?= htmlspecialchars($invitado['vehiculo']) ?>" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-light">Placa</label>
            <input type="text" name="placa" value="<?= htmlspecialchars($invitado['placa']) ?>" class="form-control">
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label text-light">Fecha de Entrada</label>
            <input type="date" name="fecha_entrada" value="<?= htmlspecialchars($invitado['fecha_entrada']) ?>" class="form-control" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label text-light">Hora de Entrada</label>
            <input type="time" name="hora_entrada" value="<?= htmlspecialchars($invitado['hora_entrada']) ?>" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label text-light">Motivo</label>
          <textarea name="motivo" rows="3" class="form-control"><?= htmlspecialchars($invitado['motivo']) ?></textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
             <!-- Botón Volver -->
                <a href="consultar_invitado.php" class="btn btn-outline-light">← Volver</a>

             <!-- Botón Guardar Cambios -->
            <button type="submit" class="btn btn-outline-light">
                💾 Guardar Cambios
            </button>
</div>
      </form>
    </div>
  </div>
</body>
</html>
