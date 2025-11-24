<?php
require 'config.php';

function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

$mensaje = "";
$tipoMensaje = "success";

// Obtener listas para selects
$estudiantesRes = $conn->query("SELECT id, nombre FROM estudiantes ORDER BY nombre");
$materiasRes = $conn->query("SELECT id, nombre FROM materias ORDER BY nombre");

// Estudiante seleccionado desde index
$estudianteSeleccionado = isset($_GET['estudiante_id']) ? (int)$_GET['estudiante_id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $estudiante_id = (int)($_POST['estudiante_id'] ?? 0);
    $materia_id = (int)($_POST['materia_id'] ?? 0);
    $nota = trim($_POST['nota'] ?? '');

    // Validaciones
    if ($nota === "") {
        $mensaje = "La nota no puede estar vacía.";
        $tipoMensaje = "danger";
    } elseif (!is_numeric($nota)) {
        $mensaje = "La nota debe ser un número.";
        $tipoMensaje = "danger";
    } elseif ($nota < 0 || $nota > 100) {
        $mensaje = "La nota debe estar entre 0 y 100.";
        $tipoMensaje = "danger";
    } elseif ($estudiante_id <= 0 || $materia_id <= 0) {
        $mensaje = "Debe seleccionar estudiante y materia.";
        $tipoMensaje = "danger";
    } else {

        // Verificar estudiante
        $stmt = $conn->prepare("SELECT COUNT(*) FROM estudiantes WHERE id = ?");
        $stmt->bind_param("i", $estudiante_id);
        $stmt->execute();
        $stmt->bind_result($countEst);
        $stmt->fetch();
        $stmt->close();

        // Verificar materia
        $stmt = $conn->prepare("SELECT COUNT(*) FROM materias WHERE id = ?");
        $stmt->bind_param("i", $materia_id);
        $stmt->execute();
        $stmt->bind_result($countMat);
        $stmt->fetch();
        $stmt->close();

        if ($countEst == 0) {
            $mensaje = "El estudiante no existe.";
            $tipoMensaje = "danger";
        } elseif ($countMat == 0) {
            $mensaje = "La materia no existe.";
            $tipoMensaje = "danger";
        } else {
            // Insertar nota
            $stmt = $conn->prepare("INSERT INTO notas(estudiante_id, materia_id, nota) VALUES (?, ?, ?)");
            $stmt->bind_param("iid", $estudiante_id, $materia_id, $nota);
            
            if ($stmt->execute()) {
                $mensaje = "Nota registrada correctamente.";
                $tipoMensaje = "success";
            } else {
                $mensaje = "Error al registrar la nota.";
                $tipoMensaje = "danger";
            }

            $stmt->close();
        }
    }

    $estudianteSeleccionado = $estudiante_id;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nota</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <h1 class="mb-4">Registrar Nota</h1>

    <a href="index.php" class="btn btn-secondary mb-3">Volver al Inicio</a>

    <?php if ($mensaje): ?>
        <div class="alert alert-<?= $tipoMensaje ?>"><?= e($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4">

        <div class="mb-3">
            <label class="form-label">Estudiante</label>
            <select name="estudiante_id" class="form-select">
                <option value="">-- Seleccione --</option>
                <?php while ($e = $estudiantesRes->fetch_assoc()): ?>
                    <option value="<?= $e['id'] ?>" 
                        <?= $e['id'] == $estudianteSeleccionado ? "selected" : "" ?>>
                        <?= e($e['nombre']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Materia</label>
            <select name="materia_id" class="form-select">
                <option value="">-- Seleccione --</option>
                <?php while ($m = $materiasRes->fetch_assoc()): ?>
                    <option value="<?= $m['id'] ?>"><?= e($m['nombre']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nota (0 - 100)</label>
            <input type="number" name="nota" min="0" max="100" step="0.01" class="form-control">
        </div>

        <button class="btn btn-primary">Guardar Nota</button>
    </form>

</div>
</body>
</html>
