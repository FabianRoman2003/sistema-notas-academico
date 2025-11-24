<?php
require 'config.php';
function e($s){return htmlspecialchars($s, ENT_QUOTES,'UTF-8');}

$msg=""; $tipo="success";

if($_SERVER['REQUEST_METHOD']==='POST'){
    $nombre=trim($_POST['nombre']);
    $ci=trim($_POST['ci']);
    $email=trim($_POST['email']);

    if($nombre==""||$ci==""||$email==""){
        $msg="Todos los campos son obligatorios"; $tipo="danger";
    } else {
        $stmt=$conn->prepare("INSERT INTO estudiantes(nombre,ci,email) VALUES(?,?,?)");
        $stmt->bind_param("sss",$nombre,$ci,$email);
        $stmt->execute();
        $msg="Estudiante registrado exitosamente";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Agregar Estudiante</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
<h1>Agregar Estudiante</h1>

<a href="index.php" class="btn btn-secondary mb-3">Volver</a>

<?php if($msg): ?>
<div class="alert alert-<?= $tipo ?>"><?= e($msg) ?></div>
<?php endif; ?>

<form method="POST" class="card p-4">
    <label>Nombre</label>
    <input type="text" name="nombre" class="form-control mb-3">

    <label>CI</label>
    <input type="text" name="ci" class="form-control mb-3">

    <label>Email</label>
    <input type="email" name="email" class="form-control mb-3">

    <button class="btn btn-success">Guardar</button>
</form>
</div>
</body>
</html>
