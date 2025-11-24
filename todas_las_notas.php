<?php
require 'config.php';

function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Obtener todas las notas con estudiante + materia
$sql = "
SELECT 
    e.id AS estudiante_id,
    e.nombre AS estudiante,
    m.nombre AS materia,
    n.nota
FROM notas n
JOIN estudiantes e ON e.id = n.estudiante_id
JOIN materias m ON m.id = n.materia_id
ORDER BY e.nombre, m.nombre
";
$res = $conn->query($sql);

// Obtener promedios por estudiante
$sqlProm = "
SELECT 
    e.id,
    e.nombre,
    AVG(n.nota) AS promedio
FROM estudiantes e
LEFT JOIN notas n ON n.estudiante_id = e.id
GROUP BY e.id, e.nombre
ORDER BY e.nombre
";
$resProm = $conn->query($sqlProm);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Todas las Notas y Promedios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

    <h1 class="mb-4">Notas de Todos los Estudiantes</h1>

    <a href="index.php" class="btn btn-secondary mb-3">Volver al inicio</a>

    <!-- Tabla de Notas -->
    <h3>Listado Completo de Notas</h3>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>Estudiante</th>
                <th>Materia</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($res->num_rows > 0): ?>
                <?php while($row = $res->fetch_assoc()): ?>
                    <tr>
                        <td><?= e($row['estudiante']) ?></td>
                        <td><?= e($row['materia']) ?></td>
                        <td><?= e($row['nota']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3" class="text-center">No hay notas registradas.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Tabla de promedios -->
    <h3 class="mt-5">Promedio General por Estudiante</h3>
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>Estudiante</th>
                <th>Promedio</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p = $resProm->fetch_assoc()): ?>
                <tr>
                    <td><?= e($p['nombre']) ?></td>
                    <td><?= $p['promedio'] !== null ? number_format($p['promedio'], 2) : "Sin notas" ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</div>
</body>
</html>
