<?php
require 'config.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
    exit;
}

// recibir JSON o form-data
$data = $_POST;

if (empty($data)) {
    $raw = file_get_contents("php://input");
    if ($raw) {
        $data = json_decode($raw, true);
    }
}

$estudiante_id = (int)($data['estudiante_id'] ?? 0);
$materia_id    = (int)($data['materia_id'] ?? 0);
$nota          = trim($data['nota'] ?? "");

// Validaciones
if ($nota === "") {
    http_response_code(400);
    echo json_encode(["error" => "La nota no puede estar vacía"]);
    exit;
}

if (!is_numeric($nota) || $nota < 0 || $nota > 100) {
    http_response_code(400);
    echo json_encode(["error" => "La nota debe estar entre 0 y 100"]);
    exit;
}

if ($estudiante_id <= 0 || $materia_id <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Debe seleccionar estudiante y materia"]);
    exit;
}

// verificar estudiante
$stmt = $conn->prepare("SELECT COUNT(*) FROM estudiantes WHERE id = ?");
$stmt->bind_param("i", $estudiante_id);
$stmt->execute();
$stmt->bind_result($existsEst);
$stmt->fetch();
$stmt->close();

if ($existsEst == 0) {
    http_response_code(400);
    echo json_encode(["error" => "El estudiante no existe"]);
    exit;
}

// verificar materia
$stmt = $conn->prepare("SELECT COUNT(*) FROM materias WHERE id = ?");
$stmt->bind_param("i", $materia_id);
$stmt->execute();
$stmt->bind_result($existsMat);
$stmt->fetch();
$stmt->close();

if ($existsMat == 0) {
    http_response_code(400);
    echo json_encode(["error" => "La materia no existe"]);
    exit;
}

// insertar nota
$stmt = $conn->prepare("INSERT INTO notas (estudiante_id, materia_id, nota) VALUES (?, ?, ?)");
$stmt->bind_param("iid", $estudiante_id, $materia_id, $nota);

if ($stmt->execute()) {
    echo json_encode(["mensaje" => "Nota registrada correctamente"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Error en la BD"]);
}

$stmt->close();
