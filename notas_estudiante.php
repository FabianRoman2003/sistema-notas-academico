<?php
require 'config.php';
function e($s){return htmlspecialchars($s);}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$stmt=$conn->prepare("SELECT nombre FROM estudiantes WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->bind_result($nombre);
$stmt->fetch();
$stmt->close();

if(!$nombre) die("Estudiante no encontrado");

$notas = $conn->query("
    SELECT m.nombre AS materia, n.nota 
    FROM notas n
    JOIN materias m ON m.id=n.materia_id
    WHERE n.estudiante_id=$id
");

$stmt2=$conn->prepare("SELECT AVG(nota) FROM notas WHERE estudiante_id=?");
$stmt2->bind_param("i",$id);
$stmt2->execute();
$stmt2->bind_result($prom);
$stmt2->fetch();
$stmt2->close();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Notas de <?= e($nombre) ?></title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
<h1>Notas de <?= e($nombre) ?></h1>

<a href="index.php" class="btn btn-secondary mb-3">Volver</a>

<table class="table table-bordered mt-3">
<thead class="table-dark">
<tr><th>Materia</th><th>Nota</th></tr>
</thead>
<tbody>
<?php while($n=$notas->fetch_assoc()): ?>
<tr>
<td><?= e($n['materia']) ?></td>
<td><?= e($n['nota']) ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<h3>Promedio: <strong><?= $prom ? number_format($prom,2) : "Sin notas" ?></strong></h3>

</div>
</body>
</html>
