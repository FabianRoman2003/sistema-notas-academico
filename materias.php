<?php
require 'config.php';
header('Content-Type: application/json; charset=utf-8');

$res = $conn->query("SELECT id, nombre FROM materias ORDER BY nombre");

$data = [];

while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
