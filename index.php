<?php
require 'config.php';

function e($str){ return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }

$res = $conn->query("SELECT * FROM estudiantes ORDER BY nombre");
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema de Notas</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

<h1 class="mb-4">Sistema de Notas Académicas</h1>

<div class="mb-3 d-flex gap-2 flex-wrap">
    <a href="agregar_estudiante.php" class="btn btn-success">Agregar Estudiante</a>
    <a href="agregar_materia.php" class="btn btn-warning">Agregar Materia</a>
    <a href="registrar_nota.php" class="btn btn-primary">Registrar Nota</a>
    <a href="todas_las_notas.php" class="btn btn-dark">Ver Todas las Notas</a>
</div>

<h2>Lista de Estudiantes</h2>

<table class="table table-bordered table-striped mt-3">
<thead class="table-dark">
<tr>
    <th>Nombre</th>
    <th>CI</th>
    <th>Email</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php while ($e = $res->fetch_assoc()): ?>
<tr>
    <td><?= e($e['nombre']) ?></td>
    <td><?= e($e['ci']) ?></td>
    <td><?= e($e['email']) ?></td>
    <td>
        <a href="notas_estudiante.php?id=<?= $e['id'] ?>" class="btn btn-info btn-sm">Ver Notas</a>
        <a href="registrar_nota.php?estudiante_id=<?= $e['id'] ?>" class="btn btn-success btn-sm">Registrar Nota</a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</div>
</body>
</html>
