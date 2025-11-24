<?php
require 'config.php';
header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT id, nombre, ci, email FROM estudiantes ORDER BY nombre";
$res = $conn->query($sql);

$data = [];

while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
