<?php
require 'config.php';
function e($s){return htmlspecialchars($s);}

$msg=""; $tipo="success";

if($_SERVER['REQUEST_METHOD']==='POST'){
    $nombre=trim($_POST['nombre']);

    if($nombre==""){
        $msg="El nombre es obligatorio"; $tipo="danger";
    } else {
        $stmt=$conn->prepare("INSERT INTO materias(nombre) VALUES(?)");
        $stmt->bind_param("s",$nombre);
        $stmt->execute();
        $msg="Materia registrada";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Agregar Materia</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
<h1>Agregar Materia</h1>
<a href="index.php" class="btn btn-secondary mb-3">Volver</a>

<?php if($msg): ?>
<div class="alert alert-<?= $tipo ?>"><?= e($msg) ?></div>
<?php endif; ?>

<form method="POST" class="card p-4">
    <label>Nombre de materia</label>
    <input type="text" name="nombre" class="form-control mb-3">
    <button class="btn btn-warning">Guardar</button>
</form>
</div>
</body>
</html>
